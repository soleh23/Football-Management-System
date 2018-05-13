<html>
	<body>
            <form action="p1.php" method="POST" onsubmit="return checkforBlank()">
			<p>Username:</p><input type="text" id = "user" name="user" />
			<p>Password:</p><input type="password"  id = "pass" name="pass" />
			<br />
			<input type="submit" value="Login" />
		</form>
	</body>
        
</html>

        <script>
            function checkforBlank()
            {
                if(document.getElementById('user').value == "" || document.getElementById('pass').value == "")
                {
                    alert('Cannot be left blank');
                    return false;
                }
            }
        </script>