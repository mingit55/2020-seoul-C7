<input type="hidden" id="uid" value="<?=user()->id?>">


<div class="wrap position-relative hx-300">
    <div class="background background--black">
        <img src="/images/visual/2.jpg" alt="비주얼 이미지" title="비주얼 이미지">
    </div>
    <div class="position-center text-center">
        <div class="fx-8 text-white mb-2 font-weight-lighter">온라인스토어</div>
        <div class="text-gray fx-3">
            한지상품판매관
            <i class="fa fa-angle-right mx-1"></i>
            온라인스토어
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="border bg-light p-3 d-center">
        <div id="search" class="w-100">
            
        </div>
        <button class="btn-search ml-3 icon text-red">
            <i class="fa fa-search"></i>
        </button>
    </div>
</div>

<div class="container py-5">
    <div class="d-between">
        <div>
            <hr class="bg-red">
            <div class="title text-red">상품 목록</div>
        </div>
        <?php if(company()):?>
            <button class="btn-custom" data-target="#insert-form" data-toggle="modal">상품 등록</button>
        <?php endif;?>
    </div>
    <div id="store" class="row border-top mt-3 pt-3">
        
    </div>
</div>

<div class="container py-5">
    <div class="pb-3 mb-3">
        <hr class="bg-yellow">
        <div class="title text-yellow">구매 목록</div>
    </div>
    <div class="t-head">
        <div class="cell-50">상품 정보</div>
        <div class="cell-20">수량</div>
        <div class="cell-20">합계 포인트</div>
        <div class="cell-10">-</div>
    </div>
    <div id="cart">
        
    </div>
    <div class="mt-3 d-between">
        <div>
            <span>총 합계 포인트</span>
            <span id="total" class="ml-2 fx-4 text-red">0</span>
            <span class="ml-1 fx-n2 text-muted">p</span>
        </div>
        <div>
            <span>보유 포인트</span>
            <span id="total" class="ml-2 fx-4 text-red"><?= number_format(user()->point) ?></span>
            <span class="ml-1 fx-n2 text-muted">p</span>
        </div>
        <form id="buy-form" action="/insert/inventory" method="post">
            <input type="hidden" id="cartList" name="cartList">
            <input type="hidden" id="totalCount" name="totalCount">
            <input type="hidden" id="totalPoint" name="totalPoint">
            <button class="btn-custom">구매 완료</button>
        </form>
    </div>
</div>

<form id="insert-form" class="modal fade" action="/insert/papers" method="post" enctype="multipart/form-data">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="fx-4">상품 등록</div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>이미지</label>
                    <input type="hidden" id="base64">
                    <input type="file" id="image" name="image" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>이름</label>
                    <input type="text" class="form-control" name="paper_name" required>
                </div>
                <div class="form-group">
                    <label>업체명</label>
                    <input type="text" class="form-control" name="company_name" value="<?=user()->user_name?>" readonly required>
                </div>
                <div class="form-group">
                    <label>가로 사이즈</label>
                    <input type="number" class="form-control" name="width_size" min="100" max="1000" required>
                </div>
                <div class="form-group">
                    <label>세로 사이즈</label>
                    <input type="number" class="form-control" name="height_size" min="100" max="1000" required>
                </div>
                <div class="form-group">
                    <label>포인트</label>
                    <input type="number" class="form-control" name="point" min="10" max="1000" step="10" required>
                </div>
                <div class="form-group">
                    <label>해시태그</label>
                    <div id="insert" data-name="hash_tags"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-custom">추가 완료</button>
            </div>
        </div>
    </div>
</form>

<script src="/js/store.js"></script>