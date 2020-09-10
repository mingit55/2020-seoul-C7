<div class="wrap position-relative hx-300">
    <div class="background background--black">
        <img src="/images/visual/2.jpg" alt="비주얼 이미지" title="비주얼 이미지">
    </div>
    <div class="position-center text-center">
        <div class="fx-8 text-white mb-2 font-weight-lighter">1:1문의</div>
        <div class="text-gray fx-3">
            축제 공지사항
            <i class="fa fa-angle-right mx-1"></i>
            1:1문의
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="d-between mb-4">
        <div>
            <hr class="bg-red">
            <div class="title text-red">1:1문의</div>
        </div>
    </div>
    <div class="t-head">
        <div class="cell-10">상태</div>
        <div class="cell-60">제목</div>
        <div class="cell-20">문의일자</div>
        <div class="cell-10">+</div>
    </div>
    <?php foreach($inquires as $inquire):?>
        <!-- 데이터 행 -->
        <div class="t-row" data-toggle="modal" data-target="#view-modal-<?=$inquire->id?>">
            <div class="cell-10"><?= $inquire->answer ? "완료" : "진행 중" ?></div>
            <div class="cell-60"><?= enc($inquire->title) ?></div>
            <div class="cell-20"><?= dt($inquire->created_at) ?></div>
            <div class="cell-10">
                <?php if(!$inquire->answer):?>
                    <button class="btn-filled" data-toggle="modal" data-target="#insert-modal-<?=$inquire->id?>">답변하기</button>
                <?php endif;?>
            </div>
        </div>
        <!-- /데이터 행 -->

        <!-- 보기 팝업 -->
        <div id="view-modal-<?=$inquire->id?>" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="fx-4">문의 내역</div>
                    </div>
                    <div class="modal-body">
                        <div class="pb-3">
                            <div class="fx-3"><?=enc($inquire->title)?></div>
                            <div class="fx-n1 text-muted mt-2">
                                <?=  $inquire->user_name ?>(<?= $inquire->user_email ?>)
                                <span class="mx-1">·</span>
                                <?= dt($inquire->created_at) ?>
                            </div>
                            <div class="mt-3 text-line"><?= enc($inquire->content) ?></div>
                        </div>
                        <div class="pt-3 border-top">
                            <?php if($inquire->answer):?>
                                <div class="fx-n1 text-muted"><?= dt($inquire->answered_at) ?></div>
                                <div class="mt-3 text-line"><?= enc($inquire->answer) ?></div>
                            <?php else:?>
                                <div class="text-line">문의에 대한 답변이 오지 않았습니다.</div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /보기 팝업 -->

        <!-- 작성 팝업 -->
        <form action="/insert/answers" method="post" id="insert-modal-<?=$inquire->id?>" class="modal fade">
            <input type="hidden" id="iid" name="iid" value="<?=$inquire->id?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="fx-4">답변하기</div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>내용</label>
                            <textarea name="answer" id="answer" cols="30" rows="10" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn-custom">작성 완료</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- /작성 팝업 -->
    <?php endforeach;?>
</div>
