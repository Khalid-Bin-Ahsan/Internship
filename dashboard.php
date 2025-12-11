<?php
require_once 'db.php';
require_once 'helpers.php';
require_once 'ml_call.php';
session_start();
require_login();

$user_id = $_SESSION['user_id'];
$role    = $_SESSION['user_role'];
$name    = $_SESSION['user_name'];

// Get company
$company = null;
if ($role === 'company') {
    $stmt = $pdo->prepare("SELECT * FROM companies WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $company = $stmt->fetch();
}

// All investors (for companies)
$all_investors = [];
if ($role === 'company') {
    $stmt = $pdo->query("SELECT id, name, picture FROM users WHERE role = 'investor' ORDER BY name");
    $all_investors = $stmt->fetchAll();
}

// Meeting requests
$meeting_requests = [];
if ($role === 'company') {
    $stmt = $pdo->prepare("SELECT mr.*, u.name as investor_name, u.picture FROM meeting_requests mr JOIN users u ON mr.investor_user_id = u.id WHERE mr.company_user_id = ? ORDER BY mr.created_at DESC");
    $stmt->execute([$user_id]);
    $meeting_requests = $stmt->fetchAll();
} else {
    $stmt = $pdo->prepare("SELECT mr.*, c.company_name FROM meeting_requests mr JOIN companies c ON mr.company_user_id = c.user_id WHERE mr.investor_user_id = ? ORDER BY mr.created_at DESC");
    $stmt->execute([$user_id]);
    $meeting_requests = $stmt->fetchAll();
}

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($role === 'company' && isset($_POST['investor_id'])) {
        $stmt = $pdo->prepare("INSERT INTO meeting_requests (company_user_id, investor_user_id, meet_time, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $_POST['investor_id'], $_POST['meet_time'] ?? null, $_POST['message'] ?? '']);
    } elseif ($role === 'investor' && isset($_POST['request_id'])) {
        $stmt = $pdo->prepare("UPDATE meeting_requests SET status = ?, meet_link = ?, meet_time = ? WHERE id = ? AND investor_user_id = ?");
        $stmt->execute([
            $_POST['action'] === 'accept' ? 'accepted' : 'rejected',
            $_POST['meet_link'] ?? null,
            $_POST['meet_time'] ?? null,
            $_POST['request_id'],
            $user_id
        ]);
    }
    redirect('dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard • BlockSight</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root{--p:#0f172a;--a:#00d4ff;--g:#00ff88;--s:#1e293b;}
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Inter',sans-serif;background:var(--p);color:white;min-height:100vh;position:relative;overflow-x:hidden;}
        body::before{content:'';position:absolute;top:0;left:0;right:0;bottom:0;background:radial-gradient(circle at 20% 80%,rgba(0,212,255,0.15)0%,transparent 50%),radial-gradient(circle at 80% 20%,rgba(0,255,136,0.15)0%,transparent 50%);animation:float 25s infinite linear;pointer-events:none;}
        @keyframes float{0%{transform:translate(0,0) rotate(0deg);}100%{transform:translate(40px,-40px) rotate(8deg);}}

        /* INTERACTIVE HEADER - FIXED & BEAUTIFUL */
        header{
            background:rgba(15,23,42,0.97);
            backdrop-filter:blur(20px);
            position:fixed;
            top:0;width:100%;z-index:1000;
            padding:1.2rem 0;
            border-bottom:2px solid rgba(0,212,255,0.3);
            box-shadow:0 10px 30px rgba(0,0,0,0.4);
            transition:all 0.4s;
        }
        header.scrolled{
            padding:0.8rem 0;
            background:rgba(15,23,42,0.99);
        }
        .container{max-width:1300px;margin:0 auto;padding:0 24px;position:relative;z-index:2;}
        .header-content{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;}
        .logo{display:flex;align-items:center;gap:14px;color:white;text-decoration:none;font-size:2.1rem;font-weight:700;transition:0.3s;}
        .logo:hover{transform:scale(1.05);}
        .logo i{color:var(--a);font-size:2.6rem;}
        .logo span{background:linear-gradient(135deg,var(--a),var(--g));-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
        nav{display:flex;align-items:center;gap:2.5rem;}
        nav a{
            color:white;
            text-decoration:none;
            font-weight:500;
            position:relative;
            padding:0.5rem 0;
            transition:all 0.3s;
        }
        nav a:hover{color:var(--a);transform:translateY(-2px);}
        nav a::after{
            content:'';
            position:absolute;
            bottom:0;left:0;width:0;height:3px;
            background:var(--a);
            transition:0.4s;
            border-radius:2px;
        }
        nav a:hover::after{width:100%;}

        main{padding:140px 20px 120px;}
        h1{font-family:'Playfair Display',serif;font-size:4rem;text-align:center;margin:0 0 3rem;background:linear-gradient(135deg,var(--a),var(--g));-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
        .card{background:rgba(255,255,255,0.09);backdrop-filter:blur(25px);border-radius:28px;padding:3rem;margin:2rem 0;box-shadow:0 30px 80px rgba(0,0,0,0.5);}
        .btn{background:linear-gradient(135deg,var(--a),var(--g));color:black;padding:1rem 2.2rem;border:none;border-radius:50px;font-weight:700;cursor:pointer;display:inline-block;margin:0.8rem 0.4rem;transition:0.4s;}
        .btn:hover{transform:scale(1.08) translateY(-5px);box-shadow:0 15px 35px rgba(0,212,255,0.5);}
        .btn-chat{background:#8b5cf6;}
        .btn-meet{background:#10b981;}
        .investor-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:2rem;margin-top:2rem;}
        .investor-card{background:rgba(255,255,255,0.12);padding:2rem;border-radius:24px;text-align:center;transition:0.5s;}
        .investor-card:hover{transform:translateY(-15px);box-shadow:0 30px 60px rgba(0,212,255,0.35);}
        .investor-img{width:110px;height:110px;border-radius:50%;object-fit:cover;border:5px solid var(--a);margin-bottom:1rem;}
        .modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.92);backdrop-filter:blur(15px);z-index:3000;align-items:center;justify-content:center;}
        .modal.active{display:flex;}
        .modal-content{background:rgba(15,23,42,0.95);border:2px solid var(--a);border-radius:28px;padding:3.5rem;max-width:600px;width:90%;position:relative;}
        .close-modal{position:absolute;top:20px;right:25px;font-size:3rem;cursor:pointer;color:#64748b;}
        .close-modal:hover{color:white;}
        footer{background:rgba(0,0,0,0.7);padding:4rem 0;text-align:center;color:#94a3b8;border-top:2px solid var(--a);}
    </style>
</head>
<body>
    <!-- INTERACTIVE HEADER -->
    <header id="mainHeader">
        <div class="container header-content">
            <a href="dashboard.php" class="logo">
                <i class="fas fa-eye"></i>
                <span>BlockSight</span>
            </a>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <?php if($role === 'company'): ?>
                    <a href="funding_create.php">Raise Capital</a>
                <?php else: ?>
                    <a href="fundings.php">Invest</a>
                <?php endif; ?>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <h1>Welcome, <?=esc($name)?>!</h1>

        <?php if($role === 'company'): ?>
            <?php if($company): ?>
                <?php $risk = calculate_risk_score($company); ?>
                <div class="card" style="text-align:center;">
                    <h2>Your Startup</h2>
                    <div style="padding:3rem;background:var(--s);border-radius:24px;margin:2rem 0;">
                        <div style="font-size:5.5rem;font-weight:800;color:<?=$risk['color']?>;">
                            <?=$risk['score']?>
                        </div>
                        <h3 style="color:<?=$risk['color']?>;font-size:2rem;margin:1rem 0;"><?=$risk['level']?></h3>
                        <p style="font-size:1.4rem;"><strong><?=esc($company['company_name'])?></strong></p>
                    </div>
                    <a href="funding_create.php" class="btn">Raise Capital</a>
                </div>

                <div class="card">
                    <h2>All Investors</h2>
                    <div class="investor-grid">
                        <?php foreach($all_investors as $inv): ?>
                        <div class="investor-card">
                            <img src="<?=esc($inv['picture'] ?: 'https://via.placeholder.com/110/1e293b/ffffff?text=' . substr($inv['name'],0,2)) ?>" 
                                 alt="Investor" class="investor-img">
                            <h3><?=esc($inv['name'])?></h3>
                            <button class="btn btn-meet" onclick="openModal('meeting',<?=$inv['id']?>,'<?=addslashes($inv['name'])?>')">
                                Request Meeting
                            </button>
                            <button class="btn btn-chat" onclick="alert('Direct messaging coming soon!')">
                                Message
                            </button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if(!empty($meeting_requests)): ?>
                <div class="card">
                    <h2>Your Meeting Requests</h2>
                    <?php foreach($meeting_requests as $req): ?>
                    <div style="background:rgba(255,255,255,0.1);padding:2rem;border-radius:20px;margin:1rem 0;">
                        <p><strong>To:</strong> <?=esc($req['investor_name'])?></p>
                        <p><strong>Status:</strong> 
                            <span style="color:<?=$req['status']==='accepted'?'#10b981':($req['status']==='rejected'?'#ef4444':'#f59e0b')?>">
                                <?=ucfirst($req['status'])?>
                            </span>
                        </p>
                        <?php if($req['status'] === 'accepted' && $req['meet_link']): ?>
                            <p><strong>Meeting Link:</strong> <a href="<?=esc($req['meet_link'])?>" target="_blank" class="btn">Join Now</a></p>
                            <p><strong>Time:</strong> <?=date('M d, Y h:i A', strtotime($req['meet_time']))?></p>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="card" style="text-align:center;">
                    <h2>Start Your Journey</h2>
                    <p>Create your company profile to raise capital</p>
                    <a href="company_create.php" class="btn" style="font-size:2rem;padding:2rem 5rem;">Create Company</a>
                </div>
            <?php endif; ?>

        <?php else: // Investor ?>
            <div class="card" style="text-align:center;">
                <h2>Investor Dashboard</h2>
                <p>Discover verified startups</p>
                <a href="fundings.php" class="btn" style="font-size:2rem;padding:2rem 5rem;">Browse Deals</a>
            </div>

            <?php if(!empty($meeting_requests)): ?>
            <div class="card">
                <h2>Meeting Requests</h2>
                <?php foreach($meeting_requests as $req): ?>
                <div style="background:rgba(255,255,255,0.1);padding:2rem;border-radius:20px;margin:1rem 0;">
                    <p><strong>From:</strong> <?=esc($req['company_name'])?></p>
                    <p><strong>Message:</strong> <?=esc($req['message'])?></p>
                    <p><strong>Proposed Time:</strong> <?=date('M d, Y h:i A', strtotime($req['meet_time']))?></p>

                    <?php if($req['status'] === 'pending'): ?>
                    <form method="post">
                        <input type="hidden" name="request_id" value="<?=$req['id']?>">
                        <input type="datetime-local" name="meet_time" value="<?=date('Y-m-d\TH:i', strtotime($req['meet_time']))?>" style="width:100%;padding:1rem;margin:1rem 0;border-radius:12px;background:rgba(255,255,255,0.1);border:none;color:white;">
                        <input type="text" name="meet_link" placeholder="Enter Zoom/Meet link" required style="width:100%;padding:1rem;margin:1rem 0;border-radius:12px;background:rgba(255,255,255,0.1);border:none;color:white;">
                        <button type="submit" name="action" value="accept" class="btn" style="background:#10b981;">Accept & Send Link</button>
                        <button type="submit" name="action" value="rejected" class="btn" style="background:#ef4444;">Reject</button>
                    </form>
                    <?php else: ?>
                        <p><strong>Status:</strong> <?=ucfirst($req['status'])?></p>
                        <?php if($req['meet_link']): ?>
                            <a href="<?=esc($req['meet_link'])?>" target="_blank" class="btn">Join Meeting</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Meeting Modal -->
    <div class="modal" id="meetingModal">
        <div class="modal-content">
            <span class="close-modal" onclick="document.getElementById('meetingModal').classList.remove('active')">&times;</span>
            <h2>Request Meeting with <span id="investorName"></span></h2>
            <form method="post">
                <input type="hidden" id="investorId" name="investor_id">
                <input type="datetime-local" name="meet_time" required style="width:100%;padding:1.2rem;margin:1rem 0;border-radius:16px;background:rgba(255,255,255,0.1);border:none;color:white;">
                <textarea name="message" placeholder="Your message..." style="width:100%;height:120px;padding:1.2rem;margin:1rem 0;border-radius:16px;background:rgba(255,255,255,0.1);border:none;color:white;"></textarea>
                <button type="submit" class="btn">Send Request</button>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        function openModal(type, id, name) {
            document.getElementById('investorName').textContent = name;
            document.getElementById('investorId').value = id;
            document.getElementById('meetingModal').classList.add('active');
        }
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', e => {
                if(e.target === modal) modal.classList.remove('active');
            });
        });

        // Smooth header on scroll
        window.addEventListener('scroll', () => {
            document.getElementById('mainHeader').classList.toggle('scrolled', window.scrollY > 50);
        });
    </script>
</body>
</html>