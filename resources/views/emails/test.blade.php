<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mailer Demo</title>
</head>

<body>
Hello {{ $firstname }} {{ $lastname }},
<br>
     You have been invited to a project on Pdmsys, register yourself <a href="http://localhost:8080/pdmsys/#/invitation/{{ $urlcode }}">here</a> and check your project out.
     If the link is not working, please copy http://localhost:8080/pdmsys/#/invitation/{{ $urlcode }} manually into your browser.
<br>
Kind Regards
<br>
Pdmsys-Admin
</body>
</html>
