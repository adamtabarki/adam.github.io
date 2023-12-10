<?php
include "connect.php";
session_start();
session_regenerate_id(true);
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}
$userId=$_SESSION["user"]["id"];
$userPoints=$_SESSION["user"]["points"];


if($userPoints!=NULL){
    $getuserPoints="select points from users where id=$userId";
    $result=mysqli_query($connection,$getuserPoints);
    $user=mysqli_fetch_array($result,MYSQLI_ASSOC);
    $userPoints=$user["points"];
}
else{
    $userPoints=0;
}
$redeemPointsUrl = 'redeemPoints.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GiftGem-Account</title>
    <style>
       body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    color: #333;
}

nav {
    background-color: #2c3e50;
    color: #ecf0f1;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

nav a {
    text-decoration: none;
    color: #ecf0f1;
    transition: color 0.3s ease;
}

nav a:hover {
    color: #3498db;
}

nav img {
    width: 80px;
}

.nav-links ul {
    list-style: none;
    display: flex;
}

.nav-links li {
    margin: 0 15px;
}

button {
    background-color: #3498db;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #2980b9;
}

section {
    padding: 20px;
    background-color: #fff;
    margin-top: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease;
}

section:hover {
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
}

.back, .bonus, .reward {
    background-color: #ecf0f1;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease;
}

.back:hover, .bonus:hover, .reward:hover {
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
}

.gifts {
    justify-content: space-around;
}

.reward {
    text-align: center;
    width: 200px;
    margin: 10px;
    transition: transform 0.3s ease;
}

.reward:hover {
    transform: translateY(-5px);
}

.reward img {
    max-width: 100%;
    border-radius: 5px;
}

h2, h3 {
    color: #333;
}

hr {
    border: 1px solid #3498db;
}

#background-video {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: -1;
}

body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    z-index: -2;
}

    </style>
</head>
<body>
    <video id="background-video" autoplay loop muted>
        <source src="money.mp4" type="video/mp4">
    </video>
    <nav>
        <a href="index.html" >
            <img src="logo.png" alt="GiftGem">
        </a>
        <div class="nav-links">
            <ul>
                <li><a href="#" data-uri="balance">Balance</a></li>
                <li><a href="#" data-uri="earn">Earn</a></li>
                <li><a href="#" data-uri="rewards">Rewards</a></li>
            </ul>
        </div>
        <a href="logout.php"><button>Logout</button></a>
    </nav>

    

    <section id="content-balance" >
        <div class="back">
        <h2>Balance Page</h2>
        <hr color="blue">
        <p id="points">0</p>
        </div>
    </section>

    <section id="content-earn" style="display: none;">
        <div class="bonus">
            <h2>Daily Bonus</h2>
            <p>Click the button to claim your daily bonus points:</p>
            <button onclick="claimDailyBonus(<?php echo $userId; ?>)">Claim Daily Bonus</button>
        </div>
    </section>

    <section id="content-rewards" style="display: none;">
        <h2 style="text-align:center;">Reward Catalog</h2>
        <div class="gifts" style="display:flex; ">
            <div class="reward">
                <img src="googlecard.png" alt="googlecard"><h3>Google Play Gift Card - $5</h3>
                <p>Cost: 50 points</p>
                <button onclick="redeemReward(50)">Redeem</button>
            </div>
            <div class="reward">
                <img src="steamcard.png" alt="steamcard"><h3>Steam Gift Card - $10</h3>
                <p>Cost: 100 points</p>
                <button onclick="redeemReward(100)">Redeem</button>
            </div>
            <div class="reward">
                <img src="xbox.jpg" alt="steamcard"><h3>Xbox Gift card - $5</h3>
                <p>Cost: 50 points</p>
                <button onclick="redeemReward(50)">Redeem</button>
            </div>
            <div class="reward">
                <img src="psn.jpg" alt="steamcard"><h3>PSN Gift Card - $5</h3>
                <p>Cost: 100 points</p>
                <button onclick="redeemReward(100)">Redeem</button>
            </div>
            <div class="reward">
                <img src="psnplus.webp" alt="steamcard"><h3>PSN PLUS Gift Card - $5</h3>
                <p>Cost: 50 points</p>
                <button onclick="redeemReward(50)">Redeem</button>
            </div>
            <div class="reward">
                <img src="amazon.png" alt="steamcard"><h3>Amazon Gift Card - $5</h3>
                <p>Cost: 100 points</p>
                <button onclick="redeemReward(100)">Redeem</button>
            </div>
        </div>
    </section>



    <script>
        let lastClaimedTime = 0;
        let userId = <?php echo $userId; ?>;
        let userPoints = <?php echo $userPoints; ?>;
        let redeemPointsUrl = '<?php echo $redeemPointsUrl; ?>';
        document.getElementById("points").textContent = userPoints;
        function redeemReward(cost) {
            if (userPoints>=cost){
            // Use AJAX to communicate with the server-side PHP script
            fetch(redeemPointsUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    userId: userId,
                    pointsToRedeem: cost,
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Points redeemed:', data);
                
                if (data.success) {
                    userPoints -= cost;
                    updatePointsDisplay();
                } else {
                    alert('Error redeeming points: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error redeeming points:', error);
            });
            alert('Points redeemed successfully!');
            }
            else{
                alert('Not enough points');
            }
            updatePointsDisplay();
        }

        function claimDailyBonus(userId) {
            const currentTime = Date.now();
            const twentyFourHours = 24 * 60 * 60 * 1000;

            if (currentTime - lastClaimedTime >= twentyFourHours) {
                userPoints += 50;
                lastClaimedTime = currentTime;

                
                fetch('updatePoints.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        userId: userId,
                        points: userPoints,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Points updated:', data);
                    
                })
                .catch(error => {
                    console.error('Error updating points:', error);
                });
                alert('Daily bonus points claimed!');
            } else {
                const remainingTime = twentyFourHours - (currentTime - lastClaimedTime);
                const hoursRemaining = Math.floor(remainingTime / (60 * 60 * 1000));
                const minutesRemaining = Math.floor((remainingTime % (60 * 60 * 1000)) / (60 * 1000));
                alert("You can claim your daily bonus in " + hoursRemaining + " hours and " + minutesRemaining + " minutes.");
            }
            updatePointsDisplay();
        }


        function updatePointsDisplay() {
            document.getElementById("points").textContent = userPoints;
        }

        document.querySelectorAll('[data-uri]').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const uri = link.getAttribute('data-uri');
                document.querySelectorAll('section[id^="content-"]').forEach(section => {
                    section.style.display = 'none';
                });
                document.getElementById(`content-${uri}`).style.display = 'block';
            });
        });
    </script>
</body>
</html>