<?php
namespace Controller;

use App\DB;

class ActionController {
    function init(){
        $admin = DB::who("admin");
        if(!$admin){
            DB::query("INSERT INTO users(user_email, password, user_name, type) VALUES (?, ?, ?, 'admin')", [
                "admin",
                "1234",
                "관리자"
            ]);
        }
    }

    function signUp(){
        checkEmpty();
        extract($_POST);

        $image = $_FILES['image'];
        $filename = time(). "-" . $image['name'];
        move_uploaded_file($image['tmp_name'], UPLOAD."/$filename");

        DB::query("INSERT INTO users(user_email, password, user_name, image, type) VALUES (?, ?, ?, ?, ?)" ,[
            $user_email,
            $password,
            $user_name,
            $filename,
            $type
        ]);

        go("/", "정상적으로 회원가입 되었습니다.");
    }

    function signIn(){
        checkEmpty();
        extract($_POST);

        $user = DB::who($user_email);
        if(!$user) back("아이디와 일치하는 회원이 존재하지 않습니다.");
        if($user->password !== $password) back("비밀번호가 일치하지 않습니다.");

        $_SESSION['user'] = $user;

        go("/", "로그인 되었습니다.");
    }

    function signOut(){
        unset($_SESSION['user']);
        go("/", "로그아웃 되었습니다.");
    }


    // 공지사항
    function insertNotice(){
        checkEmpty();
        extract($_POST);

        $files = $_FILES['files'];
        $fileLength = count($files['name']);
        $ff = $files['name'][0];
        $filenames = [];

        if($ff){
            for($i = 0; $i < $fileLength; $i++){
                $name = $files['name'][$i];
                $tmp_name = $files['tmp_name'][$i];
                $size = $files['size'][$i];
                $filename = time() ."-" . $name;
                
                
                if($size > 1024 * 1024 * 10) back("파일은 10BM 이하만 업로드할 수 있습니다.");
                if($i > 3) back("파일은 4개까지만 업로드 가능합니다.");

                $filenames[] = $filename;
                move_uploaded_file($tmp_name, UPLOAD."/$filename");
            }
        }

        DB::query("INSERT INTO notices(title, content, files) VALUES (?, ?, ?)", [$title, $content, json_encode($filenames)]);

        go("/notices", "공지사항을 작성했습니다.");
    }

    function updateNotice($id){
        $notice = DB::find("notices", $id);
        if(!$notice) back("대상을 찾을 수 없습니다.");
        checkEmpty();
        extract($_POST);
 
        $files = $_FILES['files'];
        $fileLength = count($files['name']);
        $ff = $files['name'][0];
        $filenames = json_decode($notice->files);

        if($ff){
            $filenames = [];
            for($i = 0; $i < $fileLength; $i++){
                $name = $files['name'][$i];
                $tmp_name = $files['tmp_name'][$i];
                $size = $files['size'][$i];
                $filename = time() ."-" . $name;
                
                
                if($size > 1024 * 1024 * 10) back("파일은 10BM 이하만 업로드할 수 있습니다.");
                if($i > 3) back("파일은 4개까지만 업로드 가능합니다.");

                $filenames[] = $filename;
                move_uploaded_file($tmp_name, UPLOAD."/$filename");
            }
        }

        DB::query("UPDATE notices SET title = ?, content = ?, files = ? WHERE id = ?", [$title, $content, json_encode($filenames), $id]);

        go("/notices/$id", "공지사항을 수정했습니다.");
    }

    function deleteNotice($id){
        $notice = DB::find("notices", $id);
        if(!$notice) back("대상을 찾을 수 없습니다.");

        DB::query("DELETE FROM notices WHERE id = ?", [$id]);

        go("/notices", "공지사항을 삭제했습니다.");
    }

    function downloadFile($filename){
        $fileinfo = fileinfo(urldecode($filename));
        if(is_file($fileinfo->local_name)){
            header("Content-Disposition: attachment; filename={$fileinfo->origin_name}");
            readfile($fileinfo->local_name);
        }
    }

    // 문의하기
    function insertInquire(){
        checkEmpty();
        extract($_POST);

        DB::query("INSERT INTO inquires(uid, title, content) VALUES (?, ?, ?)", [user()->id, $title, $content]);
        go("/inquires", "작성했습니다.");
    }

    function insertAnswer(){
        checkEmpty();
        extract($_POST);
        
        DB::query("INSERT INTO answers(iid, answer) VALUES (?, ?)", [$iid, $answer]);

        go("/inquires", "작성했습니다.");
    }

    // 온라인스토어
    function insertPaper(){
        checkEmpty();
        extract($_POST);

        $image = $_FILES['image'];
        $filename = time(). "-". $image['name'];
        move_uploaded_file($image['tmp_name'], UPLOAD."/$filename");


        DB::query("INSERT INTO papers(paper_name, uid, width_size, height_size, point, hash_tags, image) VALUES (?, ?, ?, ?, ?, ?, ?)", [
            $paper_name,
            user()->id,
            $width_size,
            $height_size,
            $point,
            $hash_tags,
            "/uploads/$filename"
        ]);

        $pid = DB::lastInsertId();
        DB::query("INSERT INTO inventory (uid, pid, hasCount) VALUES (?, ? ,?)", [user()->id, $pid, -1]);

        go("/store"," 한지를 추가했습니다.");
    }

    function insertInventory(){
        checkEmpty();
        extract($_POST);

        if(user()->point < $totalPoint) {
            back("포인트가 부족하여 구매하실 수 없습니다.");
        }
        
        foreach(json_decode($cartList) as $item){
            $paper = DB::find("papers", $item->id);
            $point = $item->buyCount * $paper->point;
            
            $exist = DB::fetch("SELECT * FROM inventory WHERE uid = ? AND pid = ?", [user()->id, $paper->id]);
            if($exist) {
                DB::query("UPDATE inventory SET hasCount = hasCount + ? WHERE uid = ? AND pid = ?", [$item->buyCount, user()->id, $paper->id]);
            } else {
                DB::query("INSERT INTO inventory(uid, pid, hasCount) VALUES (?, ?, ?)", [user()->id, $paper->id, $item->buyCount]);
            }

            DB::query("UPDATE users SET point = point - ? WHERE id = ?", [$point, user()->id]);
            DB::query("UPDATE users SET point = point + ? WHERE id = ?", [$point, $paper->uid]);
            DB::query("INSERT INTO history(uid, point) VALUES (?, ?)", [$paper->uid, $point]);
        }

        go("/store", "총 {$totalCount}개의 한지가 구매되었습니다.");
    }

    function updateInventory($id){
        $item = DB::find("inventory", $id);
        if(!$item || $item->uid !== user()->id) return;

        checkEmpty();
        extract($_POST);

        DB::query("UPDATE inventory SET hasCount = ? WHERE id = ?", [$count, $id]);
    }
    
    function deleteInventory($id){
        $item = DB::find("inventory", $id);
        if(!$item || $item->uid !== user()->id) return;

        DB::query("DELETE FROM inventory WHERE id = ?", [$id]);
    }

    function insertArtwork(){
        checkEmpty();
        extract($_POST);

        $filename = upload_base64($image);
        DB::query("INSERT INTO artworks(uid, title, content, hash_tags, image) VALUES (?, ?, ?, ?, ?)", [user()->id, $title, $content, $hash_tags, $filename]);

        go("/entry", "출품이 완료되었습니다.");
    }

    function updateArtwork($id){
        $artwork = DB::find("artworks", $id);
        if(!$artwork) back("대상을 찾을 수 없습니다.");
        checkEmpty();
        extract($_POST);

        DB::query("UPDATE artworks SET title = ?, content = ?, hash_tags = ? WHERE id = ?", [$title, $content, $hash_tags, $id]);

        go("/artworks/$id", "수정되었습니다.");
    }

    function deleteArtwork($id){
        $artwork = DB::find("artworks", $id);
        if(!$artwork) back("대상을 찾을 수 없습니다.");

        DB::query("DELETE FROM artworks WHERE id = ?", [$id]);

        go("/artworks", "삭제되었습니다.");
    }

    function deleteArtworkByAdmin($id){
        $artwork = DB::find("artworks", $id);
        if(!$artwork) back("대상을 찾을 수 없습니다.");
        checkEmpty();
        extract($_POST);

        DB::query("UPDATE artworks SET rm_reason = ? WHERE id = ?", [$rm_reason, $id]);

        go("/artworks", "삭제되었습니다.");
    }

    function insertScore(){
        checkEmpty();
        extract($_POST);

        $artwork = DB::find("artworks", $aid);
        if(!$artwork) back("대상을 찾을 수 없습니다.");

        DB::query("INSERT INTO scores(uid, aid, score) VALUES (?, ?, ?)", [user()->id, $aid, $score]);
        DB::query("UPDATE users SET score = ? WHERE id = ?", [$score * 100, $artwork->uid]);

        go("/artworks/$aid");
    }
}