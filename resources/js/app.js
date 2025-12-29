import './bootstrap';
import '../css/app.css';

import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;
Alpine.start();

createIcons({ icons });
