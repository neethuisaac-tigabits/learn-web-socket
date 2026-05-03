import { createRoot } from 'react-dom/client';

// document.body.innerHTML = '<div id="app"></div>';

function NavigationBar() {
    return (
    <nav>
        <ul class="main-nav">
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>
    );
}


const domNode = document.getElementById('navigation');
const root = createRoot(domNode);
root.render(<NavigationBar />);
console.log('trying react');

