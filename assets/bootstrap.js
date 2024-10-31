import { startStimulusApp } from '@symfony/stimulus-bundle';
import LiveController from '@symfony/ux-live-component';
import '@symfony/ux-live-component/styles/live.css';
import '@symfony/stimulus-bundle';

const app = startStimulusApp();
app.register('live', LiveController);
// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);
