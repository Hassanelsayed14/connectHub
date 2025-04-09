<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About This Project</title>
    <link rel="stylesheet" href="general.css">
    <link rel="stylesheet" href="about.css">
</head>
<body>
<nav class="navbar">
        <a class="nav-brand" href="home.php">ConnectHub</a>
        <div class="nav-links">
            <a href="about.php">About</a>
            <a href="login.php" class="btn btn-login">Login</a>
            <a href="signup.php" class="btn btn-signup">Sign Up</a>
        </div>
    </nav>
    <div class="hero">
    <h1>About This Project</h1>
    <p>This web application is a deliberately <span>vulnerable</span> platform developed as part of a university project aimed at educating developers and cybersecurity students on common security issues.</p>
    <br>
    <p>It intentionally exhibits the <span>OWASP Top 10</span> vulnerabilities, a set of the most critical security risks identified by the <span>Open Web Application Security Project (OWASP)</span>. Through this platform, developers and students can understand how these vulnerabilities are introduced, identified, and the potential impact they can have on web applications.</p>
    </div>
    <div class="purpose-section">
        <div class="info-titles">
        <hr>
        <h2>Purpose</h2>
        <hr>
        </div>
        <div class="info-text">
            <p>The primary goal of this project is to foster a practical understanding of web application <span>security risks</span> and to promote secure coding practices. By experimenting with this <span>vulnerable application</span>, users gain insights into how <span>attackers</span> exploit these common vulnerabilities, bridging the gap between theory and real-world application security.</p>
        </div>
    </div>
    <div class="learning-section">
        <div class="info-titles">
            <hr>
            <h2>Learning Objectives</h2>
            <hr>
        </div>
        <div class="info-text">
        <ul>
        <li><h4>Raise Awareness</h4> <br> <p>Highlight the significance of application security by showcasing real-world vulnerabilities.</p></li>
        <li><h4>Identify and Understand Risks</h4> <br><p>Help students and developers recognize vulnerabilities, understand their root causes, and learn about their threats.</p></li>
        <li><h4>Promote Secure Development Practices</h4> <br><p>Encourage secure coding practices by showcasing vulnerabilities and guiding users on remediation.</p></li>
    </ul>
        </div>
    </div>
    <div class="vulnerabilities-section">
        <div class="info-titles">
            <hr>
            <h2>Vulnerabilities Covered</h2>
            <hr>
        </div>
        <div class="info-text">
        <li><h4>Injection (e.g., SQL Injection)</h4> <p>Manipulating input to execute unintended commands.</p></li>
        <li><h4>Broken Authentication</h4><p> Exploiting flaws in authentication to compromise credentials. <p></li>
        <li><h4>Sensitive Data Exposure</h4> <p>Inadequate protection of sensitive information. <p></li>
        <li><h4>XML External Entities (XXE)</h4> <p>Processing external entities in XML, leading to data breaches.<p></li>
        <li><h4>Broken Access Control</h4><p> Unauthorized access to restricted resources.<p></li>
        <li><h4>Security Misconfiguration</h4> <p>Improper configurations that lead to security gaps.<p></li>
        <li><h4>Cross-Site Scripting (XSS)</h4><p> Injection of malicious scripts into webpages.<p></li>
        <li><h4>Insecure Deserialization</h4><p> Deserialization of untrusted data, leading to remote code execution.<p></li>
        <li><h4>Using Components with Known Vulnerabilities</h4><p> Reliance on outdated or vulnerable libraries.<p></li>
        <li><h4>Insufficient Logging and Monitoring</h4><p> Lack of comprehensive logging and detection mechanisms.<p></li>
        </div>
    </div>
    <p class="important">Important Notice: This project is strictly for educational purposes and should not be used in any production environment. Unauthorized exploitation or distribution outside a controlled environment is not allowed and may violate ethical and legal standards.</p>
    <div class="future-section">
        <div class="info-titles">
        <hr>
        <h2>Future Development</h2>
        <hr>
        </div>
        <div class="info-text">
        <p>Future enhancements could include mitigation strategies for each vulnerability, enabling users to learn both the <span>attack</span> and <span>defense</span> aspects of web security, building a well-rounded foundation in secure application development.</p>

        </div>
    </div>
</div>
<footer>
<p>&copy; 2024 ConnectHub. All rights reserved.</p>
</footer>
</body>
</html>