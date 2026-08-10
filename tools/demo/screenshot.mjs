// CDP を直接叩いてスクリーンショットを撮る（playwright パッケージ不要）
//
// ビューポートを一度だけ設定し、captureBeyondViewport でページ全体を撮る。
// 撮影の途中でビューポートを測り直して付け替えると、再レイアウトと
// スクロール位置のずれで左右が切れるため、リサイズは行わない。
import { writeFileSync } from 'node:fs';

const BASE = process.env.BASE || 'https://yui666a.github.io/job-openings-plugin';
const OUT = process.env.OUT || '.';
const PORT = process.env.PORT || '9333';

// [出力名, パス, ビューポート幅, 高さ]
// 幅は「そのページが横に溢れない値」。プラグインの CSS は width:100% と
// padding:4% が加算される作りのため、内容幅より広めに取る必要がある。
// 高さはページ全体が入る値（captureBeyondViewport で下方向は伸びる）。
const SHOTS = [
  ['index',        'index.html',        1280, 900],
  ['entry',        'entry.html',        1400, 900],
  ['public-list',  'public-list.html',  1400, 900],
  ['job-list',     'job-list.html',     1500, 900],
  ['company-list', 'company-list.html', 1500, 900],
  ['add-card',     'add-card.html',     1400, 900],
  ['add-company',  'add-company.html',  1400, 900],
];

const HIDE = '.demo-bar,.demo-banner,.demo-note{display:none !important}';

const res = await fetch(`http://127.0.0.1:${PORT}/json/version`);
const { webSocketDebuggerUrl } = await res.json();
const ws = new WebSocket(webSocketDebuggerUrl);
await new Promise((resolve, reject) => { ws.onopen = resolve; ws.onerror = reject; });

let msgId = 0;
const pending = new Map();
ws.onmessage = (e) => {
  const msg = JSON.parse(e.data);
  if (msg.id && pending.has(msg.id)) {
    const { resolve, reject } = pending.get(msg.id);
    pending.delete(msg.id);
    msg.error ? reject(new Error(JSON.stringify(msg.error))) : resolve(msg.result);
  }
};
const send = (method, params = {}, sessionId) => new Promise((resolve, reject) => {
  const m = { id: ++msgId, method, params };
  if (sessionId) m.sessionId = sessionId;
  pending.set(m.id, { resolve, reject });
  ws.send(JSON.stringify(m));
});

const { targetId } = await send('Target.createTarget', { url: 'about:blank' });
const { sessionId } = await send('Target.attachToTarget', { targetId, flatten: true });
const S = (m, p) => send(m, p, sessionId);

await S('Page.enable');
await S('Runtime.enable');

for (const [name, path, width, height] of SHOTS) {
  await S('Emulation.setDeviceMetricsOverride', {
    width, height, deviceScaleFactor: 2, mobile: false,
  });
  await S('Page.navigate', { url: `${BASE}/${path}` });
  await new Promise((r) => setTimeout(r, 2500));

  await S('Runtime.evaluate', {
    expression: `(()=>{const s=document.createElement('style');s.textContent=${JSON.stringify(HIDE)};document.head.appendChild(s);})()`,
  });
  // select2 による職種セレクタの構築を待つ
  await new Promise((r) => setTimeout(r, 700));

  const { data } = await S('Page.captureScreenshot', {
    format: 'png',
    captureBeyondViewport: true,
  });
  writeFileSync(`${OUT}/${name}.png`, Buffer.from(data, 'base64'));
  console.log('shot', name);
}

ws.close();
process.exit(0);
