document.querySelectorAll('[data-tooltip]').forEach(element => {
    element.addEventListener('mouseover', function () {
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.innerText = element.getAttribute('data-tooltip');
        document.body.appendChild(tooltip);

        const rect = element.getBoundingClientRect();
        tooltip.style.left = `${rect.left + window.scrollX}px`;
        tooltip.style.top = `${rect.bottom + window.scrollY + 5}px`;

        element.addEventListener('mouseleave', () => tooltip.remove());
    });
});
