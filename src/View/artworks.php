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
        <form class="border bg-light p-3 d-center">
            <div id="search" class="w-100" data-name="searches">
                
            </div>
            <button class="btn-search ml-3 icon text-red">
                <i class="fa fa-search"></i>
            </button>
        </form>
    </div>
    <script>
        let module = new HashModule("#search", <?= json_encode($tags, JSON_UNESCAPED_UNICODE) ?>);
        module.tags = <?= json_encode($searches, JSON_UNESCAPED_UNICODE) ?>;
        module.update();
    </script>

<div class="container py-5">
        <div class="pb-3 mb-3 border-bottom">
            <hr>
            <div class="title">나의 작품</div>
        </div>
        <div class="row">
            <?php foreach($myList as $artwork): ?>
                <div class="col-lg-4">
                    <div class="border bg-white" onclick="location.href='/artworks/<?=$artwork->id?>';" <?= $artwork->rm_reason ? 'disabled' :'' ?>>
                        <img src="/uploads/<?=$artwork->image?>" alt="이미지" class="fit-cover hx-200">
                        <div class="p-3 border-top">
                            <div class="fx-3"><?= enc($artwork->title) ?></div>
                            <div class="mt-2">
                                <span class="fx-n2 text-muted">제작자</span>
                                <span class="fx-n1 ml-2"><?= $artwork->user_name ?></span>
                                <span class="badge badge-primary"><?= $artwork->type == 'company' ? '기업' : '일반' ?></span>
                            </div>
                            <div class="mt-2">
                                <span class="fx-n2 text-muted">평점</span>
                                <span class="fx-n1 ml-2"><?= $artwork->score ?></span>
                            </div>
                            <div class="mt-2">
                                <span class="fx-n2 text-muted">제작일자</span>
                                <span class="fx-n1 ml-2"><?= dt($artwork->created_at) ?></span>
                            </div>
                            <div class="mt-2 fx-n2 text-muted d-flex flex-wrap">
                                <?php foreach($artwork->hash_tags as $tag):?>
                                    <span class="m-1">#<?=$tag?></span>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                    <?php if($artwork->rm_reason):?>
                    <div class="p-3 border">
                        <div class="fx-n1 font-weight-bold">삭제 사유</div>
                        <div class="text-line"><?=enc($artwork->rm_reason)?></div>
                    </div>
                    <?php endif;?>
                </div>
            <?php endforeach;?>
        </div>
    </div>
    <div class="container py-5">
        <div class="pb-3 mb-3 border-bottom">
            <hr>
            <div class="title">우수 작품</div>
        </div>
        <div class="row">
            <?php foreach($rankers as $artwork): ?>
                <div class="col-lg-4">
                    <div class="border bg-white" onclick="location.href='/artworks/<?=$artwork->id?>';">
                        <img src="/uploads/<?=$artwork->image?>" alt="이미지" class="fit-cover hx-200">
                        <div class="p-3 border-top">
                            <div>
                                <span class="fx-3"><?= enc($artwork->title) ?></span>
                                <span class="badge badge-danger">우수작품</span>
                            </div>
                            <div class="mt-2">
                                <span class="fx-n2 text-muted">제작자</span>
                                <span class="fx-n1 ml-2"><?= $artwork->user_name ?></span>
                                <span class="badge badge-primary"><?= $artwork->type == 'company' ? '기업' : '일반' ?></span>
                            </div>
                            <div class="mt-2">
                                <span class="fx-n2 text-muted">평점</span>
                                <span class="fx-n1 ml-2"><?= $artwork->score ?></span>
                            </div>
                            <div class="mt-2">
                                <span class="fx-n2 text-muted">제작일자</span>
                                <span class="fx-n1 ml-2"><?= dt($artwork->created_at) ?></span>
                            </div>
                            <div class="mt-2 fx-n2 text-muted d-flex flex-wrap">
                                <?php foreach($artwork->hash_tags as $tag):?>
                                    <span class="m-1">#<?=$tag?></span>
                                <?php endforeach;?>
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
            <div class="title">모든 작품</div>
        </div>
        <div class="row">
            <?php foreach($artworks->data as $artwork): ?>
                <div class="col-lg-4">
                    <div class="border bg-white" onclick="location.href='/artworks/<?=$artwork->id?>';">
                        <img src="/uploads/<?=$artwork->image?>" alt="이미지" class="fit-cover hx-200">
                        <div class="p-3 border-top">
                            <div class="fx-3"><?= enc($artwork->title) ?></div>
                            <div class="mt-2">
                                <span class="fx-n2 text-muted">제작자</span>
                                <span class="fx-n1 ml-2"><?= $artwork->user_name ?></span>
                                <span class="badge badge-primary"><?= $artwork->type == 'company' ? '기업' : '일반' ?></span>
                            </div>
                            <div class="mt-2">
                                <span class="fx-n2 text-muted">평점</span>
                                <span class="fx-n1 ml-2"><?= $artwork->score ?></span>
                            </div>
                            <div class="mt-2">
                                <span class="fx-n2 text-muted">제작일자</span>
                                <span class="fx-n1 ml-2"><?= dt($artwork->created_at) ?></span>
                            </div>
                            <div class="mt-2 fx-n2 text-muted d-flex flex-wrap">
                                <?php foreach($artwork->hash_tags as $tag):?>
                                    <span class="m-1">#<?=$tag?></span>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
        <div class="mt-4 d-center">
            <a href="/artworks?page=<?=$artworks->prevPage?>" class="mx-1 icon bg-red text-white" <?= !$artworks->prev ? "disabled" : "" ?> >
                <i class="fa fa-angle-left"></i>
            </a>
            <?php for($i = $artworks->start; $i <= $artworks->end; $i++):?>
                <a href="/artworks?page=<?=$i?>" class="mx-1 icon <?= $i == $artworks->page ? "bg-red text-white" : "border border-red text-red" ?>"><?=$i?></a>
            <?php endfor;?>
            <a href="/artworks?page=<?=$artworks->nextPage?>" class="mx-1 icon bg-red text-white" <?= !$artworks->next ? "disabled" : "" ?> >
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </div>