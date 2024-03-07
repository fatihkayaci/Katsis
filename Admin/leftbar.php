<?php
$idapartman =$_SESSION["apartID"];
?>

<body class="g-sidenav-show bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="index?parametre=dashboard">
        <img src="assets/img/ico.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">KATSİS</span>
      </a>
    </div>

    <hr class="horizontal dark mt-0">

    <div class="collapse navbar-collapse w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav leftbar">
        <li class="mt-3">
          <h6 class="ps-4 ms-2 text-xs font-weight-bolder opacity-6">Ana Başlıklar</h6>
        </li>

        <a class="nav-item" href="index?parametre=dashboard">
          <li class="nav-link mb-1">
            <div class="nav-ico">
              <i class="fa-solid fa-house"></i>
            </div>
            <span class="nav-link-text ms-1 py-1">Ana Sayfa</span>
          </li>
        </a>
        <a class="nav-item" href="index?parametre=Accounts">
          <li class="nav-link my-1">
            <div class="nav-ico">
              <i class="fa-solid fa-users"></i>
            </div>
            <span class="nav-link-text ms-1 py-1">Kullanıcılar</span>
          </li>
        </a>
        <a class="nav-item" href="index?parametre=Sections">
          <li class="nav-link my-1">
            <div class="nav-ico">
              <i class="fa-solid fa-building"></i>
            </div>
            <span class="nav-link-text ms-1 py-1">Bölümler</span>
          </li>
        </a>
        
        <hr class="horizontal dark m-0">
        
        <li class="mt-3">
          <h6 class="ps-4 ms-2 text-xs font-weight-bolder opacity-6">Hesap Ayarları</h6>
        </li>

        <a class="nav-item" href="index?parametre=profile">
          <li class="nav-link">
            <div class="nav-ico">
              <i class="fa-solid fa-user"></i>
            </div>
            <span class="nav-link-text ms-1">Profilim</span>
          </li>
        </a>
        <a class="nav-item" href="../logout">
          <li class="nav-link">
            <div class="nav-ico">
            <i class="fa-solid fa-right-from-bracket"></i>
            </div>
            <span class="nav-link-text ms-1">Çıkış Yap</span>
          </li>
        </a>
      </ul>
      <hr class="horizontal dark">

<?php
$sql = " SELECT * FROM tbl_apartman where apartman_id = $idapartman ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Sonuç kümesinin satır sayısını kontrol etme
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
      <div class="apart-col">

        <hr class="horizontal mt-0 mb-2 dark w-100">
        
        <div class="apart-ad">
          <div class="apart-ico">
          <i class="fa-solid fa-earth-americas"></i>
          </div>
          <p class="apart-text"><?php echo $result['apartman_name']; ?></p>
        </div>
      </div>

    </div>
    
  </aside>
  <main class="main-content position-relative max-height-vh-100 border-radius-lg">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 nav-m-3 border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">

        <nav aria-label="breadcrumb">
          <h6 id="pageName" class="font-weight-bolder mb-0"></h6>
        </nav>
        
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            
            <ul class="navbar-nav  justify-content-end">
              
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                  <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                      <i class="sidenav-toggler-line"></i>
                      <i class="sidenav-toggler-line"></i>
                      <i class="sidenav-toggler-line"></i>
                    </div>
                  </a>
                </li>

                <li class="nav-item dropdown px-1 d-flex align-items-center">
                  <a href="javascript:;" class="nav-link text-body header-ico1 p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">

                    <div class="user-profile-main">
                      <div class="user-avatar">
                        <p><i class="fa fa-bell toggle-icon1 cursor-pointer"></i></p>
        	          	</div>
                    </div>

                    <div class="header-name">
                      <span class="name-title1"> <strong> 3 </strong> Adet</span>
                      <span class="d-sm-inline toggle-icon d-none resize">Bildirimler</span>
                    </div>

                    <i class="fa-solid fa-sort-down fa-sort-down2" id="btn-rotate1"></i>

                  </a>
                  <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4x" aria-labelledby="dropdownMenuButton">
                    <li class="mb-2">
                      <a class="dropdown-item border-radius-md" href="javascript:;">
                        <div class="d-flex py-1">
                          <div class="my-auto">
                            <img src="assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="text-sm font-weight-normal mb-1">
                              <span class="font-weight-bold">New message</span> from Laur
                            </h6>
                            <p class="text-xs text-secondary mb-0 ">
                              <i class="fa fa-clock me-1"></i>
                              13 minutes ago
                            </p>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li class="mb-2">
                      <a class="dropdown-item border-radius-md" href="javascript:;">
                        <div class="d-flex py-1">
                          <div class="my-auto">
                            <img src="assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="text-sm font-weight-normal mb-1">
                              <span class="font-weight-bold">New album</span> by Travis Scott
                            </h6>
                            <p class="text-xs text-secondary mb-0 ">
                              <i class="fa fa-clock me-1"></i>
                              1 day
                            </p>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item border-radius-md" href="javascript:;">
                        <div class="d-flex py-1">
                          <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                            <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                              <title>credit-card</title>
                              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                  <g transform="translate(1716.000000, 291.000000)">
                                    <g transform="translate(453.000000, 454.000000)">
                                      <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                      <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                    </g>
                                  </g>
                                </g>
                              </g>
                            </svg>
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="text-sm font-weight-normal mb-1">
                              Payment successfully completed
                            </h6>
                            <p class="text-xs text-secondary mb-0 ">
                              <i class="fa fa-clock me-1"></i>
                              2 days
                            </p>
                          </div>
                        </div>
                      </a>
                    </li>
                  </ul>
                </li>

                <div class="vertical-hr"></div>

                <?php
                    $names = explode(" ", $_SESSION["userName"]);
                    $initials = "";
                    $count = 0;
                    foreach ($names as $name) {
                        $initials .= strtoupper(substr($name, 0, 1));
                        $count++;
                        if ($count == 2) {
                            break;
                        }
                    }
                ?>

                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                  <a href="" class="nav-link nav-link header-ico font-weight-bold mb-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    
                    <div class="user-profile-main">
                      <div class="user-avatar">
        	          		<p><?php echo $initials; ?></p>
        	          	</div>
                    </div>

                    <div class="header-name">
                      <span class="name-title">Kullanıcı</span>
                      <span class="d-sm-inline toggle-icon d-none">
                          <?php  echo $_SESSION["userName"]; ?>
                      </span>
                    </div>

                    <i class="fa-solid fa-sort-down fa-sort-down1" id="btn-rotate"></i>

                  </a>
                  <ul class="dropdown-menu dropdown-menu-end px-2" aria-labelledby="dropdownMenuButton">
                    <li class="mb-1">
                      <a class="dropdown-item border-radius-md" href="index?parametre=profile">
                        <div class="d-flex py-1">
                          <div class="my-auto">
                            <i class="fa-solid fa-user avatar avatar-sm bg-gradient-light i-color me-3"></i>
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="text-sm font-weight-normal mb-1">
                              <span class="font-weight-bold">Profilim</span>
                            </h6>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li class="mb-0">
                      <a class="dropdown-item border-radius-md" href="../logout">
                        <div class="d-flex py-1">
                          <div class="my-auto">
                            <i class="fa-solid fa-right-from-bracket avatar avatar-sm bg-gradient-light i-color me-3"></i>
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="text-sm font-weight-normal mb-1">
                              <span class="font-weight-bold">Çıkış Yap</span>
                            </h6>
                          </div>
                        </div>
                      </a>
                    </li>
                  </ul>
                </li>
  
              </li>
            </ul>
          </div>  
        </div>
      </div>
    </nav>

    <!-- 
      
    
    orta tarafı silindi
        ve
    settings silindi. 
  -->
  <!--   Core JS Files   -->
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/chartjs.min.js"></script>
  
  <script>
  // Tüm nav linklerini seçin
  const navLinks = document.querySelectorAll('.nav-item');

  // Her bir nav linki için bir olay dinleyici ekleyin
  navLinks.forEach(link => {
    link.addEventListener('click', function(event) {
      // Tüm nav linklerinden active sınıfını kaldırın
      navLinks.forEach(link => {
        link.classList.remove('active');
      });

      this.classList.add('active');

      const selectedParam = this.getAttribute('href').split('=')[1];
      localStorage.setItem('selectedLink', selectedParam);
    });
  });

  // Sayfa yüklendiğinde seçili bağlantıyı geri yükleyin
  window.addEventListener('load', function() {
    const selectedParam = localStorage.getItem('selectedLink');
    if (selectedParam) {
      const selectedLink = document.querySelector(`.nav-item[href*="${selectedParam}"]`);
      if (selectedLink) {
        selectedLink.classList.add('active');
      }
    } else {
      // localStorage'da seçili bağlantı yoksa, varsayılan olarak dashboard'u seç
      const defaultLink = document.querySelector('.nav-item[href*="dashboard"]');
      if (defaultLink) {
        defaultLink.classList.add('active');
        localStorage.setItem('selectedLink', 'dashboard');
      }
    }
  });

  // Çıkış yapıldığında localStorage'daki seçili bağlantıyı temizle
  function logout() {
    localStorage.removeItem('selectedLink');
    // Burada gerektiğinde başka çıkış işlemleri de gerçekleştirebilirsiniz
  }
</script>


  
  <script>

  document.addEventListener('DOMContentLoaded', function () {
    var headerIco = document.querySelector('.header-ico');
    var toggleIcon = headerIco.querySelector('.toggle-icon');
    var headerIco1 = document.querySelector('.header-ico1');
    var toggleIcon1 = headerIco.querySelector('.toggle-icon1');
    var btnRotate = document.querySelector('#btn-rotate');
    var userAvatarP = document.querySelector('.name-title');
    var btnRotate1 = document.querySelector('#btn-rotate1');

    headerIco.addEventListener('click', function (event) {
      event.stopPropagation(); // Header içinde tıklamalarda sadece bu fonksiyon çalışsın
      headerIco.classList.toggle('active');
      btnRotate.classList.toggle('rotate1');
      userAvatarP.classList.toggle('active');
    });

    headerIco1.addEventListener('click', function (event) {
      event.stopPropagation(); // Header içinde tıklamalarda sadece bu fonksiyon çalışsın
      headerIco1.classList.toggle('active');
      btnRotate1.classList.toggle('rotate1');
    });

    // Document düzeyinde tıklamaları dinle
    document.addEventListener('click', function (event) {
      var isClickInsideHeader = headerIco.contains(event.target);
      var isClickInsideHeader = headerIco1.contains(event.target);
      if (!isClickInsideHeader) {
        headerIco.classList.remove('active');
        headerIco1.classList.remove('active');
        btnRotate.classList.remove('rotate1');
        userAvatarP.classList.remove('active');
        btnRotate1.classList.remove('rotate1');
      }
    });
  });



    var ctx = document.getElementById("chart-bars").getContext("2d");

    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Sales",
          tension: 0.4,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "#fff",
          data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
          maxBarThickness: 6
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
            },
            ticks: {
              suggestedMin: 0,
              suggestedMax: 500,
              beginAtZero: true,
              padding: 15,
              font: {
                size: 14,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
              color: "#fff"
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false
            },
            ticks: {
              display: false
            },
          },
        },
      },
    });


    var ctx2 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

    var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

    gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
    gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Mobile apps",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#cb0c9f",
            borderWidth: 3,
            backgroundColor: gradientStroke1,
            fill: true,
            data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
            maxBarThickness: 6

          },
          {
            label: "Websites",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#3A416F",
            borderWidth: 3,
            backgroundColor: gradientStroke2,
            fill: true,
            data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
            maxBarThickness: 6
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#b2b9bf',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#b2b9bf',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
</body>

</html>