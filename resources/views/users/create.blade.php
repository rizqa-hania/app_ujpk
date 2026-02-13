<h3> Tambah User </h3>
<form action ="{{route('users.store')}}" method="POST">
 {{ csrf_field() }}   

 <label> Name : </label><br>
 <input type="text" name="name"><br>

 <label> Email : </label><br>
 <input type="email" name="email"><br>

 <label> Password : </label><br>
 <input type="password" name="password"><br>

 <label> Role </label> <br>
 <input type="radio" name="role" value="admin"> Admin </br>
 <input type="radio" name="role" value="super_admin">Super Admin</br>

 <button type="submit">Simpan</button>
</form>
