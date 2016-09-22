<div class="admin_login_all">
  <div class="admin_login">  
    <form class="form-horizontal" method="post" action="./login/login_check.php" name="admin_login">
	
      <div class="form-group">
        <label class="control-label" for="inputEmail">管理員帳號</label>
        <label class="login_err_msg" id="login_account_msg"></label>
        <div class="controls">
          <input type="text" id="inputEmail" placeholder="帳號" class="form-control" name="login_account" required>
        </div>
      </div>
	  
      <div class="form-group">
        <label class="control-label" for="inputPassword">密碼　　　</label>
		<label class="login_err_msg" id="login_passwd_msg"></label>
        <div class="controls">
          <input type="password" id="inputPassword" placeholder="密碼" class="form-control" name="login_passwd" required>
        </div>
      </div>
	  
      <div class="form-group">
        <div class="controls">
		  <input type="submit" name="login_submit" class="btn btn-primary" style="width:300px" value="登入" onclick="return check_login()">     
          <button type="button" class="btn btn-warning">取消</button>
        </div>
      </div>	
	  
    </form>
  </div>
</div>