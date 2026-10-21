/**
 * Generates the site's brand images (favicons, app icons, social-sharing image,
 * logo PNG and SVG wordmarks) into public_html/assets/img/brand/.
 *
 * Local development tool only; the generated files are committed, so the live
 * server never needs Node.js. Requires @resvg/resvg-js, e.g. from the Academy repo:
 *
 *   node tools/make-brand-images.mjs ../ACADEMY/node_modules
 */
import { createRequire } from 'node:module';
import { mkdirSync, writeFileSync } from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const root = path.dirname(path.dirname(fileURLToPath(import.meta.url)));
const modulesDir = path.resolve(process.argv[2] || path.join(root, 'node_modules'));
const require = createRequire(path.join(modulesDir, 'noop.js'));
const { Resvg } = require('@resvg/resvg-js');

const OUT = path.join(root, 'public_html', 'assets', 'img', 'brand');
mkdirSync(OUT, { recursive: true });

const INK = '#111214', IVORY = '#F6F3ED', GOLD = '#C6A66B', GOLD_INK = '#7E6230', MUTED = '#5F5D59';

// Wordmark geometry, identical to amaniq/src/view.php and the Academy brand files.
const CUT = '<rect x="82" y="124" width="122" height="46" rx="22"/><rect x="434" y="58" width="105" height="210" rx="10"/><rect x="619" y="58" width="105" height="210" rx="10"/><polygon points="428,56 438,56 438,98 428,80"/><polygon points="613,56 623,56 623,98 613,80"/><rect x="910" y="124" width="122" height="46" rx="22"/><rect x="1262" y="58" width="130" height="210" rx="10"/><polygon points="1256,56 1266,56 1266,98 1256,80"/><rect x="1680" y="58" width="150" height="94" rx="26"/><polygon points="1842,152 1858,152 2008,302 1992,302"/>';
const FILL = '<rect x="12" y="0" width="318" height="58" rx="16"/><rect x="250" y="0" width="80" height="210" rx="16"/><rect x="0" y="78" width="330" height="132" rx="52"/><rect x="354" y="0" width="450" height="78" rx="44"/><rect x="354" y="0" width="80" height="210" rx="16"/><rect x="539" y="0" width="80" height="210" rx="16"/><rect x="724" y="0" width="80" height="210" rx="16"/><rect x="840" y="0" width="318" height="58" rx="16"/><rect x="1078" y="0" width="80" height="210" rx="16"/><rect x="828" y="78" width="330" height="132" rx="52"/><rect x="1182" y="0" width="290" height="78" rx="44"/><rect x="1182" y="0" width="80" height="210" rx="16"/><rect x="1392" y="0" width="80" height="210" rx="16"/><rect x="1496" y="0" width="80" height="210" rx="16"/><rect x="1497" y="-119" width="78" height="78" rx="12" transform="rotate(45 1536 -80)"/><rect x="1600" y="0" width="310" height="210" rx="52"/><polygon points="1740,152 1842,152 1992,302 1890,302"/>';

/** Wordmark group placed at (x, y) scaled to width w. */
function wordmarkGroup(id, colour, x, y, w) {
  const s = w / 2008;
  return `<g transform="translate(${x} ${y}) scale(${s}) translate(8 150)">`
    + `<mask id="${id}" maskUnits="userSpaceOnUse" x="-8" y="-150" width="2008" height="460"><rect x="-8" y="-150" width="2008" height="460" fill="#fff"/><g fill="#000">${CUT}</g></mask>`
    + `<g fill="${colour}" mask="url(#${id})">${FILL}</g></g>`;
}
const wordmarkSvg = (colour) =>
  `<svg xmlns="http://www.w3.org/2000/svg" viewBox="-8 -150 2008 460" role="img" aria-label="AMANIQ"><mask id="c" maskUnits="userSpaceOnUse" x="-8" y="-150" width="2008" height="460"><rect x="-8" y="-150" width="2008" height="460" fill="#fff"/><g fill="#000">${CUT}</g></mask><g fill="${colour}" mask="url(#c)">${FILL}</g></svg>`;

const diamond = (cx, cy, r) => `${cx},${cy - r} ${cx + r},${cy} ${cx},${cy + r} ${cx - r},${cy}`;

// Icon: the wordmark's "a" in ivory with the gold diamond, on ink.
function iconSvg(size, radius) {
  const s = (size * 0.62) / 330;
  const gx = (size - 330 * s) / 2, gy = size * 0.36;
  return `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ${size} ${size}">`
    + `<rect width="${size}" height="${size}" rx="${radius}" fill="${INK}"/>`
    + `<mask id="a" maskUnits="userSpaceOnUse" x="0" y="0" width="${size}" height="${size}"><rect width="${size}" height="${size}" fill="#fff"/><g transform="translate(${gx} ${gy}) scale(${s})"><rect x="82" y="124" width="122" height="46" rx="22" fill="#000"/></g></mask>`
    + `<g mask="url(#a)"><g transform="translate(${gx} ${gy}) scale(${s})" fill="${IVORY}"><rect x="12" y="0" width="318" height="58" rx="16"/><rect x="250" y="0" width="80" height="210" rx="16"/><rect x="0" y="78" width="330" height="132" rx="52"/></g></g>`
    + `<polygon points="${diamond(size * 0.5, size * 0.2, size * 0.085)}" fill="${GOLD}"/></svg>`;
}

const png = (svg, width) => new Resvg(svg, { fitTo: { mode: 'width', value: width }, font: { loadSystemFonts: true } }).render().asPng();

writeFileSync(path.join(OUT, 'amaniq-wordmark-dark.svg'), wordmarkSvg(INK));
writeFileSync(path.join(OUT, 'amaniq-wordmark-light.svg'), wordmarkSvg(IVORY));
writeFileSync(path.join(OUT, 'favicon.svg'), iconSvg(64, 12));
writeFileSync(path.join(OUT, 'favicon-32.png'), png(iconSvg(64, 12), 32));
writeFileSync(path.join(OUT, 'apple-touch-icon.png'), png(iconSvg(180, 0), 180));
writeFileSync(path.join(OUT, 'icon-192.png'), png(iconSvg(192, 32), 192));
writeFileSync(path.join(OUT, 'icon-512.png'), png(iconSvg(512, 84), 512));

// Logo for structured data: wordmark on white with breathing room.
writeFileSync(path.join(OUT, 'amaniq-logo-512.png'), png(
  `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 160"><rect width="512" height="160" fill="#fff"/>${wordmarkGroup('l', INK, 46, 34, 420)}</svg>`, 1024));

// Social-sharing image, 1200 × 630.
const og = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 630">
  <rect width="1200" height="630" fill="${IVORY}"/>
  <rect x="790" y="0" width="410" height="630" fill="${INK}"/>
  <clipPath id="panel"><rect x="790" y="0" width="410" height="630"/></clipPath>
  <g fill="none" stroke="${GOLD}" clip-path="url(#panel)">
    <polygon points="${diamond(995, 315, 250)}" stroke-opacity="0.25"/>
    <polygon points="${diamond(995, 315, 180)}" stroke-opacity="0.5"/>
    <polygon points="${diamond(995, 315, 110)}" stroke-opacity="0.9"/>
  </g>
  <polygon points="${diamond(995, 315, 16)}" fill="${GOLD}"/>
  ${wordmarkGroup('o', INK, 80, 92, 300)}
  <rect x="80" y="196" width="64" height="2" fill="${GOLD}"/>
  <g font-family="Georgia, 'Times New Roman', serif" font-size="62" fill="${INK}">
    <text x="78" y="300">Technology. Insight.</text>
    <text x="78" y="372">Solutions that move</text>
    <text x="78" y="444" font-style="italic" fill="${GOLD_INK}">you forward.</text>
  </g>
  <text x="80" y="548" font-family="'Segoe UI', Arial, sans-serif" font-size="22" letter-spacing="1" fill="${MUTED}">AMANIQ Projects Limited · RC 9945758 · amaniqgroup.com</text>
</svg>`;
writeFileSync(path.join(OUT, 'og-default.png'), png(og, 1200));

console.log('Brand images written to', OUT);
