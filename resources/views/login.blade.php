<form action="/admin/login" method="post">
    @csrf
    <input type="email" name="email">
    <input type="password" name="password">
    <button>เข้าสู่ระบบ</button>
</form>