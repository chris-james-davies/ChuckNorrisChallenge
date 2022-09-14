import * as React from 'react';
import { createRoot } from 'react-dom/client'
import ChuckApp from './components/ChuckApp'
import { BrowserRouter as Router, Routes , Route } from "react-router-dom";

export default function App() {
    return (
        <Router>
            <Routes>
                <Route path="/" element={<ChuckApp />} />
            </Routes>
        </Router>
    );
}

if (document.getElementById('root')) {
    createRoot(document.getElementById('root')).render(<App />)
}
