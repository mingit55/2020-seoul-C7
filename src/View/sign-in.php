<div class="wrap position-relative hx-300">
    <div class="background background--black">
        <img src="/images/visual/2.jpg" alt="비주얼 이미지" title="비주얼 이미지">
    </div>
    <div class="position-center text-center">
        <div class="fx-8 text-white mb-2 font-weight-lighter">로그인</div>
        <div class="text-gray fx-3">
            사용자 계정
            <i class="fa fa-angle-right mx-1"></i>
            로그인
        </div>
    </div>
</div>

<div class="container py-5">
    <form action="/sign-in" method="post">
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
        <div class="form-group mt-3 text-right">
            <button class="btn-custom">로그인</button>
        </div>
    </form>
</div>
