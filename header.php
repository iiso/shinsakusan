	<nav class="navigation">
      <div class="nav-wrap">
        <ul class="nav-static">
          <li class="home"><a href="home.php"><span>SHINSAKU-SAN</span></a></li>
          <li class="search"><a href="./search-result-nothing.php">登録する</a></li>
         <li class="profile"><a href="./profile.php?id=<?php print( $_SESSION['user']['member_id']); ?>">マイリスト</a></li>
        </ul>
      </div>
    </nav>