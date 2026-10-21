<?php partial('page-hero', [
    'eyebrow' => 'Mission, Vision & Values',
    'title' => 'What we are working towards, and <em>how we get there.</em>',
    'lead' => 'Our mission, vision and values set the standard for how we engage clients, deliver work and build the company.',
    'crumbs' => $meta['breadcrumbs'],
]) ?>

<section class="section section--white">
    <div class="container">
        <div class="mv-grid">
            <article class="mv-card" data-reveal>
                <p class="eyebrow">Our mission</p>
                <p class="mv-statement">To deliver reliable technology, consulting, digital, training and procurement solutions that help organisations solve problems, strengthen capabilities and achieve <em>sustainable progress.</em></p>
            </article>
            <article class="mv-card mv-card--dark" data-reveal data-delay="1">
                <p class="eyebrow eyebrow--on-dark">Our vision</p>
                <p class="mv-statement">To build a trusted, innovative and internationally recognised Nigerian company known for integrity, excellence and practical solutions that create <em>lasting value.</em></p>
            </article>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head section-head--split">
            <div data-reveal>
                <p class="eyebrow">Core values</p>
                <h2 class="section-title">Six values. <em>Applied every day.</em></h2>
            </div>
            <p class="section-intro" data-reveal data-delay="1">Values only matter when they shape decisions. These are the standards we use to judge our own work.</p>
        </div>
        <ol class="values-grid">
            <?php foreach ([
                ['Integrity', 'We are honest and transparent in what we say and do, including when that means saying no.'],
                ['Excellence', 'We set high standards for the quality of our advice, our deliverables and our service.'],
                ['Innovation', 'We look for better ways to solve problems, using technology where it genuinely helps.'],
                ['Accountability', 'We take ownership of our commitments and the results of our work.'],
                ['Client focus', 'We shape our work around our clients’ objectives and communicate clearly throughout.'],
                ['Continuous learning', 'We keep our knowledge current and help others build their skills.'],
            ] as $i => [$title, $text]): ?>
            <li class="value" data-reveal data-delay="<?= $i % 3 + 1 ?>">
                <span class="value-num"><?= sprintf('%02d', $i + 1) ?></span>
                <span class="value-diamond" aria-hidden="true"></span>
                <h3 class="value-title"><?= e($title) ?></h3>
                <p><?= e($text) ?></p>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>

<?php partial('cta-band', [
    'title' => 'Work with a team that holds itself to these standards.',
    'text' => 'Whether you need technical expertise, independent advice, training or procurement support, we would be glad to hear about it.',
]) ?>
