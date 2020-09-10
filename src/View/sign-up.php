<div class="wrap position-relative hx-300">
    <div class="background background--black">
        <img src="/images/visual/2.jpg" alt="비주얼 이미지" title="비주얼 이미지">
    </div>
    <div class="position-center text-center">
        <div class="fx-8 text-white mb-2 font-weight-lighter">회원가입</div>
        <div class="text-gray fx-3">
            사용자 계정
            <i class="fa fa-angle-right mx-1"></i>
            회원가입
        </div>
    </div>
</div>

<div class="container py-5">
    <form action="/sign-up" method="post" enctype="multipart/form-data" id="sign-up">
        <div class="form-group">
            <label for="user_email">이메일</label>
            <input type="text" id="user_email" class="form-control" name="user_email">
            <div class="error text-red mt-2 fx-n2"></div>
        </div>
        <div class="form-group">
            <label for="password">비밀번호</label>
            <input type="password" id="password" class="form-control" name="password">
            <div class="error text-red mt-2 fx-n2"></div>
        </div>
        <div class="form-group">
            <label for="passconf">비밀번호 확인</label>
            <input type="password" id="passconf" class="form-control" name="passconf">
            <div class="error text-red mt-2 fx-n2"></div>
        </div>
        <div class="form-group">
            <label for="user_name">이름</label>
            <input type="text" id="user_name" class="form-control" name="user_name">
            <div class="error text-red mt-2 fx-n2"></div>
        </div>
        <div class="form-group">
            <label for="image">프로필 사진</label>
            <input type="file" id="image" class="form-control" name="image" accept="image/*">
            <div class="error text-red mt-2 fx-n2"></div>
        </div>
        <div class="form-group">
            <label for="type">회원 유형</label>
            <select name="type" id="type" class="form-control">
                <option value="normal">일반 회원</option>
                <option value="company">기업 회원</option>
            </select>
        </div>
        <div class="form-group mt-3 text-right">
            <button class="btn-custom">회원가입</button>
        </div>
    </form>
</div>

<script src="/js/sign-up.js"></script>