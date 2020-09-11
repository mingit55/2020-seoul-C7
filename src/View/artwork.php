<div class="wrap position-relative hx-300">
    <div class="background background--black">
        <img src="/images/visual/2.jpg" alt="비주얼 이미지" title="비주얼 이미지">
    </div>
    <div class="position-center text-center">
        <div class="fx-8 text-white mb-2 font-weight-lighter">참가작품</div>
        <div class="text-gray fx-3">
            전주한지문화축제
            <i class="fa fa-angle-right mx-1"></i>
            참가작품
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-5">
            <img src="/uploads/<?=$artwork->image?>" alt="이미지" class="fit-contain p-3 border">
        </div>
        <div class="col-lg-7">
            <div class="fx-4"><?=enc($artwork->title)?></div>
            <div class="mt-2">
                <span class="fx-1 text-muted">제작일자</span>
                <span class="ml-2 fx-2"><?=dt($artwork->created_at)?></span>
            </div>
            <div class="mt-2">
                <span class="fx-1 text-muted">평점</span>
                <span class="ml-2 fx-2"><?=$artwork->score?></span>
            </div>
            <div class="mt-2 fx-2 text-muted d-flex flex-wrap">
                <?php foreach($artwork->hash_tags as $tag):?>
                    <span class="m-1">#<?=$tag?></span>
                <?php endforeach;?>
            </div>
            <div class="mt-3 text-line">
                <?=enc($artwork->content)?>
            </div>
            <?php if(user() && user()->id == $artwork->uid):?>
                <div class="mt-5">
                    <button class="btn-filled" data-target="#update-form" data-toggle="modal">수정하기</button>
                    <a href="/delete/artworks/<?=$artwork->id?>" class="btn-bordered">삭제하기</a>
                </div>
            <?php elseif(admin()):?>
                <div class="mt-5">
                    <button class="btn-filled" data-target="#delete-form" data-toggle="modal">삭제하기</button>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>

<form action="/update/artworks/<?=$artwork->id?>" method='post' id="update-form" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-4">수정하기</div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>제목</label>
                    <input type="text" class="form-control" name="title" value="<?=$artwork->title?>" required>
                </div>
                <div class="form-group">
                    <label>내용</label>
                    <textarea name="content" id="content" cols="30" rows="10" class="form-control" required><?=$artwork->contnet?></textarea>
                </div>
                <div class="form-group">
                    <label>해시태그</label>
                    <div id="update" data-name="hash_tags"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-filled">수정 완료</button>
            </div>
        </div>
    </div>
</form>
<script>
    let module = new HashModule("#update");
    module.tags = <?=json_encode($artwork->hash_tags)?>;
    module.update();
</script>


<form action="/delete-admin/artworks/<?=$artwork->id?>" id="delete-form" class="modal fade" method="post">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-4">삭제하기</div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>삭제사유</label>
                    <textarea name="rm_reason" id="rm_reason" cols="30" rows="10" class="form-control" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-filled">삭제하기</button>
            </div>
        </div>
    </div>
</form>

<?php if(user() && user()->id !== $artwork->uid && !$artwork->reviewed):?>
<div class="container py-5">
    <form action="/insert/scores" method="post" class="border bg-light align-center p-3">
        <input type="hidden" name="aid" value="<?=$artwork->id?>">
        <select name="score" id="score" class="fa text-red form-control" style="width: auto;">
            <option value="5"><?= str_repeat("&#xf005;", 5) ?></option>
            <option value="4.5"><?= str_repeat("&#xf005;", 4) ?>&#xf123;<?= str_repeat("&#xf006;", 0) ?></option>
            <option value="4"><?= str_repeat("&#xf005;", 4) ?><?= str_repeat("&#xf006;", 1) ?></option>
            <option value="3.5"><?= str_repeat("&#xf005;", 3) ?>&#xf123;<?= str_repeat("&#xf006;", 1) ?></option>
            <option value="3"><?= str_repeat("&#xf005;", 3) ?><?= str_repeat("&#xf006;", 2) ?></option>
            <option value="2.5"><?= str_repeat("&#xf005;", 2) ?>&#xf123;<?= str_repeat("&#xf006;", 2) ?></option>
            <option value="2"><?= str_repeat("&#xf005;", 2) ?><?= str_repeat("&#xf006;", 3) ?></option>
            <option value="1.5"><?= str_repeat("&#xf005;", 1) ?>&#xf123;<?= str_repeat("&#xf006;", 3) ?></option>
            <option value="1"><?= str_repeat("&#xf005;", 1) ?><?= str_repeat("&#xf006;", 4) ?></option>
            <option value="0.5"><?= str_repeat("&#xf005;", 0) ?>&#xf123;<?= str_repeat("&#xf006;", 4) ?></option>
        </select>
        <button class="btn-filled ml-2">확인</button>
    </form>
</div>
<?php endif;?>

<div class="container py-5">
    <div class="p-3 border bg-light align-center">
        <img src="/uploads/<?=$writer->image?>" alt="이미지" width="50" height="50">
        <div class="ml-3">
            <span class="fx-3"><?=$writer->user_name?></span>
            <div class="fx-n1 text-muted">
                <?=$writer->user_email?>
                <span class="mx-1">·</span>
                <?=$writer->type == 'company' ? '기업' : '일반'?>
            </div>
        </div>
    </div>
</div>