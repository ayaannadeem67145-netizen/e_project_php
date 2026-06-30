<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-ZWPPkLtxyOYkQHyPqLq+a8+gZc0X8MdDYAjfQO2RaKXq9Xw2qKDzL9mTJah+nBDRZKqFqx4HyYIpNB4T0YN0vQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<style>
   
/* body{
  background-color:#000;
} */

.site-footer {
  background-color: #111;
  color: #fff;
  padding: 40px 20px 20px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin-top: 5rem;
}

.footer-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  max-width: 1200px;
  margin: auto;
}

.footer-section {
  flex: 1 1 200px;
  margin: 20px;
  
}

.footer-section h2,
.footer-section h3 {
  color: #e50914;
  margin-bottom: 15px;
}

.footer-section p,
.footer-section a {
  color: #ccc;
  font-size: 0.95rem;
  line-height: 1.6;
  text-decoration: none;
}

.footer-section a:hover {
  color: #e50914;
}

.social-icons a {
  color: #e50914;
  margin-right: 15px;
  font-size: 1.4rem;
  transition: color 0.3s ease;
}

.social-icons a:hover {
  color: #fff;
}

.footer-bottom {
  text-align: center;
  padding-top: 20px;
  border-top: 1px solid #333;
  font-size: 0.9rem;
  color: #999;
}

.footer {
  background-color: #111;
  padding: 20px 0;
  text-align: center;
}

.footer-links {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 20px;
}

.footer-links a {
  color: #fff;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.3s ease;
}

.footer-links a:hover {
  color: #e50914;
}

.footer-section.links ul {
  list-style: none;
  padding: 0;
  margin: 0;
  text-align: center;
}

.footer-section.links ul li {
  margin: 8px 0;
}

.footer-section.links {
  display: flex;
  flex-direction: column;
  align-items: center;
}


@media (max-width: 768px) {
  .footer-container {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .footer-section {
    margin: 15px 0;
  }

  .social-icons a {
    margin: 10px;
  }
}
@media (max-width: 768px) {
  .footer-section.links {
    align-items: center;
    justify-content: center;
  }
}


</style>





<footer class="site-footer ">
  <div class="footer-container">
    
    <div class="footer-section about">
      <h2>MYMOVIE</h2>
      <p>Your one-stop destination to book movie tickets online. Enjoy seamless booking, latest releases, and exclusive offers.</p>
    </div>

    <div class="footer-section links">
      <h3>QUICK LINKS</h3>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="movies.php">Trailers</a></li>
        <li><a href="aboutus.php">About us</a></li>
        <li><a href="Help.php">Help</a></li>
        <!-- <li><a href="logout.php">Logout</a></li>
        <li><a href="admin.php">Admin</a></li> -->
      </ul>
    </div>

    <div class="footer-section contact">
      <h3>CONTACT US</h3>
      <p>Email: support@mymovie.com</p>
      <p>Phone: +92-1234567890</p>
      <p>Address: Dollmen Mall, Tariq Road, Karachi, Pakistan</p>
    </div>

    <div class="footer-section social">
      <h3>FOLLOW US</h3>
      <div class="social-icons">
        

          <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
        <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="https://x.com" target="_blank"><i class="fab fa-x-twitter"></i></a>
        <a href="https://youtube.com" target="_blank"><i class="fab fa-youtube"></i></a>
        <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
        <a href="https://pinterest.com" target="_blank"><i class="fab fa-pinterest-p"></i></a>
      </div>
    </div>

  </div>

  <div class="footer-bottom">
    <p>&copy; 2025 MyMovie. All Rights Reserved.</p>
  </div>
</footer>