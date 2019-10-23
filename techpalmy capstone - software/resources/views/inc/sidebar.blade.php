<nav class="sidebar">
          <ul class="sidebar-section">
            <a class="nav-link" href="/companies">
              <li class="nav-item">
                <p>Companies</p>
              </li>
            </a>  

            <a class="nav-link" href="/techgroups">  
              <li class="nav-item">
                <p>Tech Groups</p>
              </li>
            </a>

            <a class="nav-link" href="/consultants">
              <li class="nav-item">
                <p>Consultants</p>
              </li>
            </a>  
          </ul>

          <ul class="sidebar-section">
            <a class="nav-link" href="/jobs">
              <li class="nav-item">
                <p>Jobs</p>
              </li>
            </a>

            <a class="nav-link" href="/events">
              <li class="nav-item">
                <p>Events</p>
              </li>
            </a>
          </ul>
          
          <ul class="sidebar-section">
            

            <li class="nav-item dropdown">
              <a id="StudentsDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  Students<span class="caret"></span>
              </a>
  
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="StudentsDropdown">
                <a href="/students" class="dropdown-item">Summer Jobs</a><br>
                <a href="/studentmi" class="dropdown-item">Student Job Search</a><br>
                <a href="/summeroftech" class="dropdown-item">Summer Of Tech</a>
              </div>
            </li>

          </ul>

          <ul class="sidebar-section">
            <a class="nav-link" href="/information_page">
              <li class="nav-item">
                <p>Information Page</p>
              </li>
            </a>
         
            <a class="nav-link" href="/about_us">
              <li class="nav-item">
                <p>About Us</p>
              </li>
            </a>

            <a class="nav-link" href="/contactus">
              <li class="nav-item">
                <p>Contact Us</p>
              </li>
            </a>

            @if (Auth::user() && Auth::user()->type == 'admin')
              <li class="nav-item dropdown">
                <a id="navbarDropdown" style="color:red" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    Admin<span class="caret"></span>
                </a>
    
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/admin/email">Email</a>
                    <a class="dropdown-item" href="/admin/sitegovernance">Site Governance</a>
                    <a class="dropdown-item" href="/admin/pendinglistings">Pending Listings</a>
                </div>
              </li>
            @endif
            
          </ul>
        </nav>

<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
</script>
