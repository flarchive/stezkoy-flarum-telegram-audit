import app from 'flarum/admin/app';
import TelegramAuditAdminPage from './components/TelegramAuditAdminPage';

app.initializers.add('stezkoy-telegram-audit', () => {
  app.registry.for('stezkoy-telegram-audit').registerPage(TelegramAuditAdminPage);
});
