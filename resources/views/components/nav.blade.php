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
        <form action="/subscriptionManagement" method="GET">
            @csrf
            <button class="font-medium text-zinc-800" id="nav-subscriptions" type="submit">Subscriptions</button>
        </form>
        <form action="/refereeManagement" method="GET">
            @csrf
            <button class="font-medium text-zinc-800" id="nav-referees" type="submit">Referees</button>
        </form>
        <form action="/managerManagement" method="GET">
            @csrf
            <button class="font-medium text-zinc-800" id="nav-managers" type="submit">Managers</button>
        </form>
        <form action="/playerManagement" method="GET">
            @csrf
            <button class="font-medium text-zinc-800" id="nav-players" type="submit">Players</button>
        </form>
        <form action="/sportManagement" method="GET">
            @csrf
            <button class="font-medium text-zinc-800" id="nav-sports" type="submit">Sports</button>
        </form>
        <form action="/leagueManagement" method="GET">
            @csrf
            <button class="font-medium text-zinc-800" id="nav-leagues" type="submit">Leagues</button>
        </form>
        <form action="/sanctionCardManagement" method="GET">
            @csrf
            <button class="font-medium text-zinc-800 whitespace-nowrap" id="nav-sanction-cards" type="submit">Sanction cards</button>
        </form>
        <form action="/sanctionCardlessManagement" method="GET">
            @csrf
            <button class="font-medium text-zinc-800 whitespace-nowrap" id="nav-sanction-cardless" type="submit">Sanction cardless</button>
        </form>
        <form action="/teamManagement" method="GET">
            @csrf
            <button class="font-medium text-zinc-800 whitespace-nowrap" id="nav-teams" type="submit">Teams</button>
        </form>
    </div>
    <form action="logout" method="POST" class="mt-12">
        @csrf
        <button type="submit" class="font-semibold">Log out</button>
    </form>
</nav>