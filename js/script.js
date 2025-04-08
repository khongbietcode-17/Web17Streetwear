document.addEventListener("DOMContentLoaded", function () {
    const myCarousel = document.querySelector('#bannerCarousel');
    const carousel = new bootstrap.Carousel(myCarousel, {
      interval: 1000,  // Thời gian chuyển slide (3 giây)
      ride: 'carousel',  // Bắt đầu tự động
      pause: 'hover'  // Dừng khi hover chuột vào
    });
  
    // Thêm hiệu ứng chuyển động mượt mà cho carousel
    myCarousel.addEventListener('slide.bs.carousel', function (event) {
      const carouselItems = document.querySelectorAll('.carousel-item');
      for (let item of carouselItems) {
        item.style.transition = 'transform 1s ease-in-out';
      }
    });
  });
  