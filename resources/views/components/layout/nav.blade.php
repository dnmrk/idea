<nav class="border-b border-border px-6">
	<div class="max-w-7xl mx-auto h-16 flex items-center justify-between">
		<div>
			<a href="">
				<img src="/images/logo.svg" alt="Idea Logo" width="100"/>
			</a>
		</div>

		<div class="flex gap-x-5 items-center">
			@auth
				<a href="{{ route('profile.edit') }}">Edit Profile</a>
				<form method="POST" action="/logout">
					@csrf
					<button>Log out</button>
				</form>
			@endauth
			@guest
				<a href="/register">Register</a>
				<a href="/login" class="btn">Sign In</a>
			@endguest

		</div>
	</div>
</nav>
