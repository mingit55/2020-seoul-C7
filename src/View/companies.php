<div class="wrap position-relative hx-300">
    <div class="background background--black">
        <img src="/images/visual/2.jpg" alt="비주얼 이미지" title="비주얼 이미지">
    </div>
    <div class="position-center text-center">
        <div class="fx-8 text-white mb-2 font-weight-lighter">한지업체</div>
        <div class="text-gray fx-3">
            한지상품판매관
            <i class="fa fa-angle-right mx-1"></i>
            한지업체
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="pb-3 mb-3 border-bottom">
        <hr>
        <div class="title">우수 업체</div>
    </div>
    <div class="row">
        <?php foreach($rankers as $company):?>
        <div class="col-lg-3">
            <div class="border bg-white">
                <img src="/uploads/<?=$company->image?>" alt="이미지" class="fit-contain hx-200 p-3">
                <div class="p-3 border-top">
                    <div>
                        <span class="fx-3"><?=$company->user_name?></span>
                        <span class="badge badge-danger">우수 업체</span>
                    </div>
                    <div class="mt-2">
                        <span class="fx-n2 text-muted">이메일</span>
                        <span class="fx-n1 ml-2"><?=$company->user_email?></span>
                    </div>
                    <div class="mt-2">
                        <span class="fx-n2 text-muted">누적 포인트</span>
                        <span class="fx-n1 ml-2"><?=$company->totalPoint?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<div class="container py-5">
    <div class="pb-3 mb-3 border-bottom">
        <hr>
        <div class="title">모든 업체</div>
    </div>
    <div class="row">
        <?php foreach($companies->data as $company):?>
        <div class="col-lg-3">
            <div class="border bg-white">
                <img src="/uploads/<?=$company->image?>" alt="이미지" class="fit-contain hx-200 p-3">
                <div class="p-3 border-top">
                    <div>
                        <span class="fx-3"><?=$company->user_name?></span>
                    </div>
                    <div class="mt-2">
                        <span class="fx-n2 text-muted">이메일</span>
                        <span class="fx-n1 ml-2"><?=$company->user_email?></span>
                    </div>
                    <div class="mt-2">
                        <span class="fx-n2 text-muted">누적 포인트</span>
                        <span class="fx-n1 ml-2"><?=$company->totalPoint?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
    <div class="mt-4 d-center">
        <a href="/companies?page=<?=$companies->prevPage?>" class="mx-1 icon bg-red text-white" <?= !$companies->prev ? "disabled" : "" ?> >
            <i class="fa fa-angle-left"></i>
        </a>
        <?php for($i = $companies->start; $i <= $companies->end; $i++):?>
            <a href="/companies?page=<?=$i?>" class="mx-1 icon <?= $i == $companies->page ? "bg-red text-white" : "border border-red text-red" ?>"><?=$i?></a>
        <?php endfor;?>
        <a href="/companies?page=<?=$companies->nextPage?>" class="mx-1 icon bg-red text-white" <?= !$companies->next ? "disabled" : "" ?> >
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
</div>