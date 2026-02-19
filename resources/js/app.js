import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {

    // ─── 1. Intersection Observer: Fade-in Sections ───
    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                obs.unobserve(entry.target);
            }
        });
    }, { root: null, rootMargin: '0px 0px -40px 0px', threshold: 0.1 });

    document.querySelectorAll('.fade-in-section').forEach(el => observer.observe(el));


    // ─── 2. Smart Navbar: Hide on scroll down, show on scroll up ───
    // Logic removed to keep navbar always visible per user request.


    // ─── 3. Ripple Effect on .btn-ripple ───
    document.querySelectorAll('.btn-ripple').forEach(button => {
        button.addEventListener('click', function (e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const size = Math.max(rect.width, rect.height);

            const ripple = document.createElement('span');
            ripple.classList.add('ripple-element');
            ripple.style.cssText = `left:${x}px; top:${y}px; width:${size}px; height:${size}px;`;

            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 700);
        });
    });


    // ─── 4. Auto-dismiss Flash Messages ───
    document.querySelectorAll('[data-flash]').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-8px)';
            setTimeout(() => el.remove(), 500);
        }, 4000);
    });


    // ─── 5. Variant Radio Styling (Product Detail Page) ───
    document.querySelectorAll('input[name="variant_id"]').forEach(input => {
        input.addEventListener('change', function () {
            document.querySelectorAll('input[name="variant_id"]').forEach(i => {
                const label = i.closest('label');
                if (label) {
                    label.classList.remove('border-blue-500', 'bg-blue-50');
                    label.classList.add('border-gray-100');
                }
            });
            if (this.checked) {
                const label = this.closest('label');
                if (label) {
                    label.classList.remove('border-gray-100');
                    label.classList.add('border-blue-500', 'bg-blue-50');
                }
            }
        });
    });


    // ─── 6. Payment Method Radio Styling ───
    document.querySelectorAll('input[name="payment_method"]').forEach(input => {
        input.addEventListener('change', function () {
            document.querySelectorAll('input[name="payment_method"]').forEach(i => {
                const wrapper = i.closest('label')?.querySelector('div');
                if (wrapper) {
                    wrapper.classList.remove('border-blue-500', 'bg-blue-50');
                    wrapper.classList.add('border-gray-100');
                }
            });
            const wrapper = this.closest('label')?.querySelector('div');
            if (wrapper) {
                wrapper.classList.remove('border-gray-100');
                wrapper.classList.add('border-blue-500', 'bg-blue-50');
            }
        });
    });

});