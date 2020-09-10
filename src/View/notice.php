<div class="wrap position-relative hx-300">
    <div class="background background--black">
        <img src="/images/visual/2.jpg" alt="비주얼 이미지" title="비주얼 이미지">
    </div>
    <div class="position-center text-center">
        <div class="fx-8 text-white mb-2 font-weight-lighter">알려드립니다</div>
        <div class="text-gray fx-3">
            축제 공지사항
            <i class="fa fa-angle-right mx-1"></i>
            알려드립니다
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="d-between">
        <div>
            <hr>
            <div class="title">알려드립니다 - <?=$notice->id?></div>
        </div>
        <?php if(admin()):?>
        <div>
            <button class="btn-filled" data-target="#update-modal" data-toggle="modal">수정하기</button>
            <a href="/delete/notices/<?=$notice->id?>" class="btn-bordered">삭제하기</a>
        </div>
        <?php endif;?>
    </div>
    <div class="text-title mt-4"><?=enc($notice->title)?></div>
    <div class="mt-2">
        <span class="fx-n2 text-muted">작성일</span>
        <span class="ml-2 fx-n1"><?=dt($notice->created_at)?></span>
    </div>
    <div class="mt-3">
        <div class="text-line"><?=enc($notice->content)?></div>
    </div>
    <div class="mt-4 row">
        <?php foreach($notice->files as $file):?>
            <?php if(isImage($file->origin_name)):?>
                <div class="col-lg-6">
                    <img class="fit-cover" src="<?=$file->view_name?>" alt="이미지">
                </div>
            <?php endif;?>
        <?php endforeach;?>
    </div>
    <div class="mt-4">
        <?php foreach($notice->files as $file):?>
        <div class="border-top d-between py-3">
            <div>
                <div class="fx-3"><?=$file->origin_name?></div>
                <div class="fx-n1 text-muted"><?=$file->size?></div>
            </div>
            <a href="/download/<?=$file->filename?>" class="btn-bordered">다운로드</a>
        </div>
        <?php endforeach;?>
    </div>
</div>

<form action="/update/notices/<?=$notice->id?>" method="post" enctype="multipart/form-data" id="update-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-4">공지 수정</div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>제목</label>
                    <input type="text" class="form-control" name="title" maxlength="50" value="<?=$notice->title?>" required>
                </div>
                <div class="form-group">
                    <label>내용</label>
                    <textarea name="content" id="content" cols="30" rows="10" class="form-control" required><?=$notice->content?></textarea>
                </div>
                <div class="form-group">
                    <label>첨부 파일</label>
                    <div class="custom-file">
                        <input type="file" id="upload" name="files[]" multiple class="custom-file-input">
                        <?php $cnt = count($notice->files);?>
                        <label for="upload" class="custom-file-label"><?= $cnt > 0 ? "{$cnt}개의 파일" : "파일을 선택하세요" ?></label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-filled">수정 완료</button>
            </div>
        </div>
    </div>
</form>