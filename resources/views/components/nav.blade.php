<nav class="flex flex-col pl-8 pr-3 pt-6 border-r-2 border-slate-500 min-h-screen w-48">
    <div class="flex flex-col gap-5">
        <form action="/userManagement" method="GET">
            @csrf
            <button class="font-medium text-zinc-800" id="nav-users" type="submit">Users</button>
        </form>
        <form action="/adminManagement" method="GET">
            @csrf
            <button class="font-medium text-zinc-800" id="nav-admins" type="submit">Admins</button>
        </form>
        <form action="/adManagement" method="GET">
            @csrf
            <button class="font-medium text-zinc-800" id="nav-ads" type="submit">Ads</button>
        </form>
        <form action="/tagManagement" method="GET">
            @csrf
            <button class="font-medium text-zinc-800" id="nav-tags" type="submit">Tags</button>
        </form>
    </div>
    <form action="logout" method="POST" class="mt-12">
        @csrf
        <button type="submit">Log out</button>
    </form>
</nav>