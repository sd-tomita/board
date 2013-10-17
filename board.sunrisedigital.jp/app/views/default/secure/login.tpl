<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Secure Signin</title>
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading">ログイン</div>
			<div class="panel-body">
				{if $failed}<div class="alert alert-danger">IDかパスワードが違います</div>{/if}
				{$form->renderStartTag() nofilter}
					<div class="form-group">
						{$form.login_id->setLabel('ログインID')->renderLabel() nofilter}
						{$form.login_id->render([class=>"form-control", placeholder=>$form.login_id->getLabel()]) nofilter}
					</div>
					<div class="form-group">
						{$form.password->setLabel('パスワード')->renderLabel() nofilter}
						{$form.password->render([class=>"form-control", placeholder=>$form.password->getLabel()]) nofilter}
					</div>
					<div class="text-center">
						<input type="submit" name="submit" name="Login" class="btn btn-success" >
					</div>
				</form>
			</div>
		</div>
	</body>
</html>