<p>Dear, {{ $user->name }}</p>

<p>
You have been registered to Yummy Lingo web service.<br>
Your password is: {{ $password }}<br>
Note that you can change it later at Yummy Lingo Console.
</p>

<p>To log in, follow <a href="{{ route('admin.content.index') }}">this</a> link.</p>

<p>Best regards,</p>

<p>Yummy Lingo</p>
