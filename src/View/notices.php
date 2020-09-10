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
    <div class="d-between mb-4">
        <div>
            <hr class="bg-red">
            <div class="title text-red">알려드립니다</div>
        </div>
        <button class="btn-bordered" data-target="#insert-modal" data-toggle="modal">공지 작성</button>
    </div>
    <div class="t-head">
        <div class="cell-10">글 번호</div>
        <div class="cell-60">제목</div>
        <div class="cell-30">작성일</div>
    </div>
    <?php foreach($notices->data as $notice):?>
    <div class="t-row" onclick="location.href='/notices/<?=$notice->id?>'">
        <div class="cell-10"><?=$notice->id?></div>
        <div class="cell-60"><?=enc($notice->title)?></div>
        <div class="cell-30"><?=dt($notice->created_at)?></div>
    </div>
    <?php endforeach?>
    <div class="mt-4 d-center">
        <a href="/notices?page=<?=$notices->prevPage?>" class="mx-1 icon bg-red text-white" <?= !$notices->prev ? "disabled" : "" ?> >
            <i class="fa fa-angle-left"></i>
        </a>
        <?php for($i = $notices->start; $i <= $notices->end; $i++):?>
            <a href="/notices?page=<?=$i?>" class="mx-1 icon <?= $i == $notices->page ? "bg-red text-white" : "border border-red text-red" ?>"><?=$i?></a>
        <?php endfor;?>
        <a href="/notices?page=<?=$notices->nextPage?>" class="mx-1 icon bg-red text-white" <?= !$notices->next ? "disabled" : "" ?> >
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
</div>

<form action="/insert/notices" method="post" enctype="multipart/form-data" id="insert-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-4">공지 작성</div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>제목</label>
                    <input type="text" class="form-control" name="title" maxlength="50" required>
                </div>
                <div class="form-group">
                    <label>내용</label>
                    <textarea name="content" id="content" cols="30" rows="10" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label>첨부 파일</label>
                    <div class="custom-file">
                        <input type="file" id="upload" name="files[]" multiple class="custom-file-input">
                        <label for="upload" class="custom-file-label">파일을 선택하세요</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-filled">작성 완료</button>
            </div>
        </div>
    </div>
</form>