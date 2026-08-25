import ExtensionPage from 'flarum/admin/components/ExtensionPage';
import Button from 'flarum/common/components/Button';
import Switch from 'flarum/common/components/Switch';

const PREFIX = 'stezkoy-telegram-audit';

export default class TelegramAuditAdminPage extends ExtensionPage {
  oninit(vnode) {
    super.oninit(vnode);

    this.setting(PREFIX + '.use_topic_id', '');
    this.setting(PREFIX + '.use_proxy', '');
    this.setting(PREFIX + '.notify_on_register', '');
    this.setting(PREFIX + '.notify_on_email_confirmed', '');
    this.setting(PREFIX + '.notify_on_flag', '');
    this.setting(PREFIX + '.notify_on_flag_deleted', '');
    this.setting(PREFIX + '.notify_on_user_suspended', '');
    this.setting(PREFIX + '.notify_on_user_unsuspended', '');
    this.setting(PREFIX + '.notify_on_user_deleted', '');
    this.setting(PREFIX + '.notify_on_user_gdpr_erased', '');
    this.setting(PREFIX + '.notify_on_discussion_renamed', '');
    this.setting(PREFIX + '.notify_on_discussion_locked', '');
    this.setting(PREFIX + '.notify_on_discussion_unlocked', '');
    this.setting(PREFIX + '.notify_on_discussion_deleted', '');
    this.testing = false;
  }

  content(vnode) {
    return m(
      '.ExtensionPage-settings',
      m(
        '.container',
        m('form.TelegramAuditAdmin', [
          this._connectionSection(),
          this._featuresSection(),
        ])
      )
    );
  }

  _connectionSection() {
    return m('section.TelegramAuditAdmin-section', [
      m('h2', app.translator.trans(PREFIX + '.admin.connection_heading')),
      m('p.helpText', app.translator.trans(PREFIX + '.admin.connection_intro')),

      this.buildSettingComponent({
        type: 'password',
        setting: PREFIX + '.bot_token',
        placeholder: '1234567890:AAF3cBd4Ee5Ff6Gg7Hh8Ii9Jj0Kk1Ll',
        label: app.translator.trans(PREFIX + '.admin.bot_token_label'),
        help: app.translator.trans(PREFIX + '.admin.bot_token_help'),
      }),

      this.buildSettingComponent({
        type: 'text',
        setting: PREFIX + '.chat_id',
        placeholder: '-1001234567890',
        label: app.translator.trans(PREFIX + '.admin.chat_id_label'),
        help: app.translator.trans(PREFIX + '.admin.chat_id_help'),
      }),

      m('.Form-group', [
        m(
          Switch,
          {
            state: this._useTopic(),
            onchange: this._toggleTopic.bind(this),
          },
          app.translator.trans(PREFIX + '.admin.use_topic_switch')
        ),
        m('p.helpText', app.translator.trans(PREFIX + '.admin.use_topic_help')),
      ]),

      this._useTopic()
        ? this.buildSettingComponent({
            type: 'number',
            setting: PREFIX + '.topic_id',
            placeholder: '123',
            label: app.translator.trans(PREFIX + '.admin.topic_id_label'),
            help: app.translator.trans(PREFIX + '.admin.topic_id_help'),
          })
        : null,

      m('.Form-group', [
        m(
          Switch,
          {
            state: this._useProxy(),
            onchange: this._toggleProxy.bind(this),
          },
          app.translator.trans(PREFIX + '.admin.use_proxy_switch')
        ),
        m('p.helpText', app.translator.trans(PREFIX + '.admin.use_proxy_help')),
      ]),

      this._useProxy()
        ? this.buildSettingComponent({
            type: 'text',
            setting: PREFIX + '.proxy',
            placeholder: 'socks5://127.0.0.1:1080',
            label: app.translator.trans(PREFIX + '.admin.proxy_label'),
            help: app.translator.trans(PREFIX + '.admin.proxy_help'),
          })
        : null,

      m('.Form-group.Form-controls', [
        m(
          Button,
          {
            className: 'Button',
            icon: 'fas fa-paper-plane',
            loading: this.testing,
            onclick: this._sendTest.bind(this),
          },
          app.translator.trans(PREFIX + '.admin.test_button')
        ),
      ]),

      m('.Form-group.Form-controls', this.submitButton()),
    ]);
  }

  _featuresSection() {
    return m('section.TelegramAuditAdmin-section', [
      m('h2', app.translator.trans(PREFIX + '.admin.features_heading')),
      m('p.helpText', app.translator.trans(PREFIX + '.admin.features_intro')),

      m('h4', app.translator.trans(PREFIX + '.admin.features_users')),
      this._toggleSwitch('notify_on_register'),
      this._toggleSwitch('notify_on_email_confirmed'),
      this._toggleSwitch('notify_on_user_suspended'),
      this._toggleSwitch('notify_on_user_unsuspended'),
      this._toggleSwitch('notify_on_user_deleted'),
      this._toggleSwitch('notify_on_user_gdpr_erased'),

      m('h4', app.translator.trans(PREFIX + '.admin.features_moderation')),
      this._toggleSwitch('notify_on_flag'),
      this._toggleSwitch('notify_on_flag_deleted'),
      this._toggleSwitch('notify_on_discussion_locked'),
      this._toggleSwitch('notify_on_discussion_unlocked'),
      this._toggleSwitch('notify_on_discussion_deleted'),
      this._toggleSwitch('notify_on_discussion_renamed'),

      m('.Form-group.Form-controls', this.submitButton()),
    ]);
  }

  _toggleSwitch(key) {
    return m('.Form-group', [
      m(
        Switch,
        {
          state: this.setting(PREFIX + '.' + key, '')() === '1',
          onchange: (value) => {
            this.setting(PREFIX + '.' + key)(value ? '1' : '');
            m.redraw();
          },
        },
        app.translator.trans(PREFIX + '.admin.' + key + '_label')
      ),
      m('p.helpText', app.translator.trans(PREFIX + '.admin.' + key + '_help')),
    ]);
  }

  _useTopic() {
    return this.setting(PREFIX + '.use_topic_id', '')() === '1';
  }

  _useProxy() {
    return this.setting(PREFIX + '.use_proxy', '')() === '1';
  }

  _toggleTopic(value) {
    this.setting(PREFIX + '.use_topic_id')(value ? '1' : '');
    m.redraw();
  }

  _toggleProxy(value) {
    this.setting(PREFIX + '.use_proxy')(value ? '1' : '');
    m.redraw();
  }

  _sendTest() {
    if (this.testing) {
      return;
    }

    this.testing = true;

    app
      .request({
        method: 'POST',
        url: app.forum.attribute('apiUrl') + '/telegram-audit/test',
      })
      .then(
        (response) => {
          this.testing = false;

          if (response.success) {
            app.alerts.show({ type: 'success' }, app.translator.trans(PREFIX + '.admin.test_ok'));
          } else {
            app.alerts.show({ type: 'error' }, response.error || app.translator.trans(PREFIX + '.admin.test_failed'));
          }

          m.redraw();
        },
        () => {
          this.testing = false;
          app.alerts.show({ type: 'error' }, app.translator.trans(PREFIX + '.admin.test_failed'));
          m.redraw();
        }
      );
  }
}
