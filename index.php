<?php
session_start();
if(isset($_SESSION["user"])){
    header("Location: account.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <title>GiftGem</title>
    </head>
    <body>
        <?php
            if (isset($_POST["submit"])){
                $email=$_POST["email"];
                require_once "connect.php";
                $req="select * from users where email='$email'";
                $result=mysqli_query($connection,$req);
                $user=mysqli_fetch_array($result,MYSQLI_ASSOC);
                if($user){
                    session_start();
                    $_SESSION["user"] = array(
                        "id" => $user["id"],
                        "email" => $user["email"],
                        "points" => $user["points"],
                    );
                    header("Location: account.php");
                    die();}
                else{
                $req="insert into users(email) values('$email')";
                $result=mysqli_query($connection,$req);
                session_start();
                $_SESSION["user"]="yes";
                header("Location : account.php");
                die();

                }
            }
            

        ?>
        <header>
            <nav>
                <a href="index.html" >
                    <img src="logo.png" alt="GiftGem">
                </a>
                <div class="nav-links">
                <ul>
                    <a href="index.html"><li>Home</li></a>
                    <a href="#"><li>About</li></a>
                    <a href="#"><li>contact</li></a>
                </ul>
                </div>
                <button type="submit">Login/Register</button>

            </nav>

        </header>
        <section class="sec">
            <img src="gift card.png" alt="gift card" width="1000px" height="600px" >  
            <div class="login">
            <h1>Earn Points,<br>
                Claim Free Gift Cards</h1>
            <form id="emailForm" action="" method="post" onsubmit="return verif()">
            <input type="email" placeholder="name@gmai.com" id="email" name="email"><button  type="submit" name="submit">Start</button><br>
            </form>
            <div id="errorText" style="color: red;"></div>
            </div>
        </section>
        <section class="sec1">
            <div class="rest">
            <h2>Earn 20+ Incredible Rewards</h2>
            <p>Instant free gift codes sent to your email address, as soon as you earn enough points!</p>
            </div>
            <div class="col">
                <img src="googleplay.png" alt="googleplay" >
                <img src="paypal.png" alt="paypal">
                <img src="steam.png" alt="steam">
            </div>
        </section >
        <section class="learn-more">
            <h2>Learn More</h2>
            <p>Discover the benefits of our service and how you can start earning rewards.</p>
            <a href="learn-more.html">Learn More</a>
        </section>
            

        <footer>
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="logo.png" alt="GiftGem">
                </div>
                <div class="footer-links">
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="contact.html">Contact</a></li>
                        <li><a href="privacy.html">Privacy</a></li>
                    </ul>
                </div>
                <div class="footer-social">
                    <a href="https://www.facebook.com/"><img src="facebook-icon.webp" alt="Facebook"></a>
                    <a href="https://twitter.com/"><img src="twitter-icon.png" alt="Twitter"></a>
                    <a href="https://www.instagram.com/"><img src="instagram-icon.png" alt="Instagram"></a>
                </div>
            </div>
            <div class="footer-text">
                <p>&copy; 2023 Your Company. All rights reserved.</p>
                <p><a href="privacy.html">Privacy Policy</a> | <a href="terms.html">Terms of Service</a></p>
            </div>
        </footer>

        
    </body>
    <script>
        function verif(){
            var email=document.getElementById("email").value;
            var errorText = document.getElementById('errorText');
            if (email === '') {
                errorText.textContent = 'Email cannot be empty.';
            return false;
            } else if (!email.includes('@')) {
                errorText.textContent = 'Invalid email format. Please include the "@" symbol.';
                return false;
            } else {
                errorText.textContent = '';
            return true;

    }
};


    </script>
</html>