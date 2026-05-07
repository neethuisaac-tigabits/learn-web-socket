import { createRoot } from 'react-dom/client';

// document.body.innerHTML = '<div id="app"></div>';

function Footer() {
    return (
        <footer>
            &copy; Tigabits @ 2026
        </footer>
    );
}


const domNode = document.getElementById('footer');
const root = createRoot(domNode);
root.render(<Footer />);
console.log('trying react');

