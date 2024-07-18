let currentIndex = 0;
const box = document.getElementsByClassName('slide');

const handleNext = () => {
    const nextIndex = currentIndex + 1 <= box.length - 1 ? currentIndex + 1 : 0;
    const currentBox = document.querySelector(`[data-index="${currentIndex}"]`);
    const nextBox = document.querySelector(`[data-index="${nextIndex}"]`);

    currentBox.dataset.status = 'hide';
    nextBox.dataset.status = 'active';

    currentIndex = nextIndex;
}

const handlePrev = () => {
    const prevIndex = currentIndex - 1 >= 0 ? currentIndex - 1 : box.length - 1;
    const currentBox = document.querySelector(`[data-index="${currentIndex}"]`);
    const prevBox = document.querySelector(`[data-index="${prevIndex}"]`);

    currentBox.dataset.status = 'hide';
    prevBox.dataset.status = 'active';

    currentIndex = prevIndex;
}

document.getElementById('prev').addEventListener('click', handlePrev);
document.getElementById('next').addEventListener('click', handleNext);


document.addEventListener("DOMContentLoaded", function() {
    const discountItems = document.querySelectorAll('.discount-item');
    
    discountItems.forEach(discountItem => {
      discountItem.addEventListener('click', function() {
        discountItems.forEach(otherDiscountItem => {
          if (otherDiscountItem !== discountItem) {
            otherDiscountItem.classList.remove('expand');
            otherDiscountItem.setAttribute('data-status', 'compress');
          }
        });
        
        if (discountItem.classList.contains('expand')) {
          discountItem.classList.remove('expand');
          discountItem.setAttribute('data-status', 'default');
        } else {
          discountItem.classList.add('expand');
          discountItem.setAttribute('data-status', 'expand');
        }
      });
    });
  });