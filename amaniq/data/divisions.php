<?php
/*
 * Business divisions of AMANIQ Projects Limited. They are divisions of one
 * legal entity, not separate companies; pages always say so.
 *
 * Each entry produces a section on /divisions/ and its own page at
 * /divisions/{slug}/. To move a division to its own subdomain later, set
 * 'external_url' and the site will link there instead (see docs/CONTENT-GUIDE.md).
 */
return [
    'technologies' => [
        'slug' => 'technologies',
        'name' => 'AMANIQ Technologies',
        'label' => 'Technologies',
        'role' => 'The technology-focused division of AMANIQ Projects Limited.',
        'tagline' => 'IT solutions, cybersecurity and technical services.',
        'summary' => 'AMANIQ Technologies delivers IT solutions, cybersecurity services, technology implementation and technical services.',
        'intro' => [
            'AMANIQ Technologies brings together our technical and cybersecurity capabilities. It works with organisations to plan, implement and support technology that is secure, reliable and fit for purpose.',
            'The division focuses on practical delivery: understanding the environment, recommending proportionate solutions and supporting implementation through to handover.',
        ],
        'focus' => ['IT solutions and implementation', 'Cybersecurity services and security operations support', 'Security technology integration', 'Technical services and infrastructure support'],
        'services' => ['cybersecurity', 'it-technology'],
        'cta' => 'Discuss a technology project',
        'enquiry' => 'cyber-it',
        'external_url' => null,
    ],
    'consulting' => [
        'slug' => 'consulting',
        'name' => 'AMANIQ Consulting',
        'label' => 'Consulting',
        'role' => 'The advisory and consulting division of AMANIQ Projects Limited.',
        'tagline' => 'Strategy, advisory and project support.',
        'summary' => 'AMANIQ Consulting provides professional consulting, technology strategy, business improvement, cybersecurity advisory and project support.',
        'intro' => [
            'AMANIQ Consulting helps leaders make well-informed decisions. It combines business understanding with technical knowledge to clarify problems, assess options and shape practical plans.',
            'Engagements are scoped around your objectives, with clear deliverables and open communication throughout.',
        ],
        'focus' => ['Professional consulting', 'Technology strategy', 'Business improvement', 'Cybersecurity advisory', 'Project and programme support'],
        'services' => ['consulting', 'cybersecurity'],
        'cta' => 'Request a consultation',
        'enquiry' => 'consulting',
        'external_url' => null,
    ],
    'digital-labs' => [
        'slug' => 'digital-labs',
        'name' => 'AMANIQ Digital Labs',
        'label' => 'Digital Labs',
        'role' => 'The digital product and innovation division of AMANIQ Projects Limited.',
        'tagline' => 'Software products, automation and innovation.',
        'summary' => 'AMANIQ Digital Labs designs and builds software products, digital solutions, applications and automation.',
        'intro' => [
            'AMANIQ Digital Labs is where ideas become working software. The division designs and develops digital products, business applications and automation that simplify how organisations work.',
            'Over time, the division will also develop AMANIQ’s own digital products, applying the same standards of security and maintainability it brings to client work.',
        ],
        'focus' => ['Software products', 'Digital solutions', 'Application development', 'Automation and process digitisation', 'Innovation and prototyping'],
        'services' => ['digital-products'],
        'cta' => 'Discuss a digital product',
        'enquiry' => 'digital',
        'external_url' => null,
    ],
    'academy' => [
        'slug' => 'academy',
        'name' => 'AMANIQ Academy',
        'label' => 'Academy',
        'role' => 'The learning and professional development division of AMANIQ Projects Limited.',
        'tagline' => 'Training, online courses and professional development.',
        'summary' => 'AMANIQ Academy offers professional training, online courses, cybersecurity education and technology skills development.',
        'intro' => [
            'AMANIQ Academy is our learning and professional development division. It is building practical, career-focused training in cybersecurity and technology for professionals, teams and individuals.',
            'Alongside training delivered for organisations, the Academy is developing a dedicated online learning platform with structured courses.',
        ],
        'focus' => ['Professional training', 'Online courses', 'Cybersecurity education', 'Technology skills development'],
        'services' => ['training'],
        'cta' => 'Explore AMANIQ Academy',
        'enquiry' => 'training',
        'external_url' => null,
    ],
];
