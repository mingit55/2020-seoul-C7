<div class="wrap position-relative hx-300">
        <div class="background background--black">
            <img src="/images/visual/2.jpg" alt="비주얼 이미지" title="비주얼 이미지">
        </div>
        <div class="position-center text-center">
            <div class="fx-8 text-white mb-2 font-weight-lighter">출품신청</div>
            <div class="text-gray fx-3">
                전주한지문화축제
                <i class="fa fa-angle-right mx-1"></i>
                출품신청
            </div>
        </div>
    </div>

    <div id="workspace">
        <canvas width="1200" height="800"></canvas>
        <div class="tool">
            <div class="tool__item" data-role="select" title="선택"><i class="fa fa-mouse-pointer"></i></div>
            <div class="tool__item" data-role="spin" title="회전"><i class="fa fa-repeat"></i></div>
            <div class="tool__item" data-role="cut" title="자르기"><i class="fa fa-cut"></i></div>
            <div class="tool__item" data-role="glue" title="붙이기"><i class="fa fa-object-group"></i></div>
            <div class="tool__item" data-target="#insert-modal" data-toggle="modal" title="추가"><i class="fa fa-folder"></i></div>
            <div class="tool__item btn-delete" title="삭제"><i class="fa fa-trash"></i></div>
        </div>
    </div>

    <div id="insert-modal" class="modal fade">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="fx-4">추가하기</div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6">
                <hr class="bg-red">
                <div class="title text-red">출품정보 입력</div>
                <form id="insert-form" action="/insert/artworks" class="mt-4" method="post">
                    <input type="hidden" id="image" name="image">
                    <div class="form-group">
                        <label>제목</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label>내용</label>
                        <textarea name="content" id="content" cols="30" rows="10" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>해시태그</label>
                        <div id="insert" data-name="hash_tags"></div>
                    </div>
                    <div class="form-group text-right mt-3">
                        <button class="btn-filled">출품하기</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-6">
                <hr class="bg-red">
                <div class="title text-red">도움말</div>
                <div class="mt-4 help">
                    <input type="radio" id="focus-select" name="tabs" hidden checked>
                    <input type="radio" id="focus-spin" name="tabs" hidden>
                    <input type="radio" id="focus-cut" name="tabs" hidden>
                    <input type="radio" id="focus-glue" name="tabs" hidden>
                    <div class="help-search align-center">
                        <input type="text" placeholder="검색어를 입력하세요" class="border fx-n2 p-1">
                        <button class="icon btn-search text-muted"><i class="fa fa-search"></i></button>
                        <button class="icon btn-prev text-muted"><i class="fa fa-angle-left"></i></button>
                        <button class="icon btn-next text-muted"><i class="fa fa-angle-right"></i></button>
                        <div class="help-message fx-n2 text-muted ml-2"></div>
                    </div>
                    <div class="help-header mt-4">
                        <label for="focus-select" class="tab select">선택</label>
                        <label for="focus-spin" class="tab spin">회전</label>
                        <label for="focus-cut" class="tab cut">자르기</label>
                        <label for="focus-glue" class="tab glue">붙이기</label>
                    </div>
                    <div class="help-body">
                        <div class="tab select text-line" data-target="#focus-select">선택 도구는 가장 기본적인 도구로써, 작업 영역 내의 한지를 선택할 수 있게 합니다. 마우스 클릭으로 한지를 활성화하여 이동시킬 수 있으며, 선택된 한지는 삭제 버튼으로 삭제시킬 수 있습니다.</div>
                        <div class="tab spin text-line" data-target="#focus-spin">회전 도구는 작업 영역 내의 한지를 회전할 수 있는 도구입니다. 마우스 더블 클릭으로 회전하고자 하는 한지를 선택하면, 좌우로 마우스를 끌어당겨 회전시킬 수 있습니다. 회전한 뒤에는 우 클릭의 콘텍스트 메뉴로 '확인'을 눌러 한지의 회전 상태를 작업 영역에 반영할 수 있습니다.</div>
                        <div class="tab cut text-line" data-target="#focus-cut">자르기 도구는 작업 영역 내의 한지를 자를 수 있는 도구입니다. 마우스 더블 클릭으로 자르고자 하는 한지를 선택하면 마우스를 움직임으로써 자르고자 하는 궤적을 그릴 수 있습니다. 궤적을 그린 뒤에는 우 클릭의 콘텍스트 메뉴로 '자르기'를 눌러 그려진 궤적에 따라 한지를 자를 수 있습니다.</div>
                        <div class="tab glue text-line" data-target="#focus-glue">붙이기 도구는 작업 영역 내의 한지들을 붙일 수 있는 도구입니다. 마우스 더블 클릭으로 붙이고자 하는 한지를 선택하면 처음 선택한 한지와 근접한 한지들을 선택할 수 있습니다. 붙일 한지를 모두 선택한 뒤에는 우 클릭의 콘텍스트 메뉴로 '붙이기'를 눌러 선택한 한지를 붙일 수 있습니다.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/entry/Tool.js"></script>
    <script src="/js/entry/Select.js"></script>
    <script src="/js/entry/Spin.js"></script>
    <script src="/js/entry/Cut.js"></script>
    <script src="/js/entry/Glue.js"></script>
    <script src="/js/entry/Source.js"></script>
    <script src="/js/entry/Part.js"></script>
    <script src="/js/entry/Workspace.js"></script>
    <script src="/js/entry.js"></script>
