// FoodFusion Main JS
// Modal pop-up for Join Us
const joinBtn = document.getElementById('joinBtn');
const joinPopup = document.getElementById('joinPopup');
const closePopup = document.getElementById('closePopup');
if (joinBtn && joinPopup && closePopup) {
    joinBtn.onclick = () => joinPopup.style.display = 'flex';
    closePopup.onclick = () => joinPopup.style.display = 'none';
    window.onclick = (e) => {
        if (e.target === joinPopup) joinPopup.style.display = 'none';
    };
}
// Cookie consent
const cookieConsent = document.getElementById('cookieConsent');
const acceptCookies = document.getElementById('acceptCookies');
if (cookieConsent && acceptCookies) {
    if (!localStorage.getItem('cookiesAccepted')) {
        cookieConsent.style.display = 'block';
    }
    acceptCookies.onclick = () => {
        localStorage.setItem('cookiesAccepted', 'yes');
        cookieConsent.style.display = 'none';
    };
}
// Simple carousel placeholder
const carousel = document.querySelector('.carousel');
if (carousel) {
    carousel.innerHTML = `
        <div class="carousel-item">Cooking Masterclass - July 15</div>
        <div class="carousel-item">Vegan Delights - July 22</div>
        <div class="carousel-item">Kids Cooking Camp - August 1</div>
    `;
    // Add carousel logic as needed
}
// News feed placeholder
const newsItems = document.getElementById('newsItems');
if (newsItems) {
    newsItems.innerHTML = `
        <div class="news-item"><strong>Summer Salads:</strong> Try our new Mediterranean Quinoa Salad!</div>
        <div class="news-item"><strong>Baking Tips:</strong> How to get the perfect sourdough crust.</div>
        <div class="news-item"><strong>Global Flavors:</strong> Explore Thai street food recipes.</div>
    `;
}
