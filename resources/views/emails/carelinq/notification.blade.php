<!DOCTYPE html>
<html>
<head>
    <title>Email Notification</title>
</head>
<body>
    <h1>This is a notification</h1>
    <p>Log information:</p>
    <ul>
        <li>id: {{ $event_log->id }}</li>
        <li>label: {{ $event_log->eventType->label }}</li>
        <li>Message: {{ $event_log->getMessage() }}</li>
    </ul>
</body>
</html>