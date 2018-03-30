<!DOCTYPE html>
<html>
<head>
    <title>New Subscription</title>
</head>
<body>
    <h1>This is a notification</h1>
    <p>Log information:</p>
    <ul>
        <li>id: {{ $event_log->id }}</li>
        <li>label: {{ $event_log->eventType->label }}</li>
        <li>Message: {{ $event_log->getMessage() }}</li>
    </ul>
    <small>—</small>
    <small>You are receiving this because you are subscribed to this thread.</small>
</body>
</html>