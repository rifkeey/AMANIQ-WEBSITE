<?php
/*
 * Team members, shown in this order on /team/. To add someone, copy an entry,
 * give it a unique slug and fill in the fields. The layout adapts automatically.
 *
 *   photo           path under public_html/assets/, e.g. 'img/team/mohammed-ibrahim.webp'
 *                   (portrait, 4:5 ratio, at least 640×800). null shows a monogram placeholder.
 *                   Only use genuine photographs supplied by the person.
 *   featured        true shows a summary of this person on the home page (one person only)
 *   bio             paragraphs, exactly as approved by the person
 *   qualifications  shown as listed — check exact credential names and current status
 *                   with the person before publishing changes
 */
return [
    'mohammed-ibrahim' => [
        'slug' => 'mohammed-ibrahim',
        'name' => 'Mohammed Ibrahim',
        'initials' => 'MI',
        'title' => 'Founder & Principal Consultant',
        'headline' => 'Cybersecurity, threat intelligence and technology consulting',
        'photo' => null,
        'featured' => true,
        'linkedin' => null,
        'summary' => 'Mohammed Ibrahim brings more than 12 years of professional experience across cybersecurity, information technology, threat intelligence, security operations and technology consulting. He holds an MSc in Advanced Computer Science, specialising in Computer Security, from the University of Manchester.',
        'belief' => 'Successful consulting goes beyond recommending solutions: it requires understanding the client’s objectives, delivering responsibly and building relationships founded on trust, competence and measurable value.',
        'bio' => [
            'Mohammed Ibrahim is the Founder and Principal Consultant of AMANIQ Projects Limited, bringing more than 12 years of professional experience across cybersecurity, information technology, threat intelligence, security operations and technology consulting.',
            'He holds an MSc in Advanced Computer Science, specialising in Computer Security, from the University of Manchester, United Kingdom, and a BSc in Computing from UCSI University, Malaysia.',
            'His professional qualifications include Certified Information Security Manager (CISM), ITIL 4, ISC² Certified in Cybersecurity (CC), EC-Council Certified SOC Analyst (CSA) and EC-Council Certified Threat Intelligence Analyst (CTIA).',
            'Throughout his career, Mohammed has worked across cybersecurity operations, threat intelligence, security monitoring, vulnerability management and the implementation of security technologies. His experience includes improving security operations, developing threat intelligence capabilities, integrating security tools and contributing to initiatives designed to strengthen cybersecurity resilience.',
            'His professional background spans public-sector institutions, financial-sector cybersecurity and consulting engagements, giving him an understanding of the technical, operational and organisational challenges that businesses and institutions face.',
            'As Founder and Principal Consultant, Mohammed’s vision for AMANIQ is to build a trusted Nigerian company that combines technical expertise, practical business insight and a strong commitment to professional integrity. He aims to help organisations navigate complex challenges through effective technology, thoughtful consulting, digital innovation, professional training and dependable service delivery.',
            'He believes successful consulting goes beyond recommending solutions: it requires understanding the client’s objectives, delivering responsibly and building relationships founded on trust, competence and measurable value.',
            'Through AMANIQ, he is committed to developing a business that grows on these principles while creating opportunities for innovation, professional development and long-term impact.',
        ],
        'education' => [
            ['MSc Advanced Computer Science (Computer Security)', 'University of Manchester, United Kingdom', '2013'],
            ['BSc Computing', 'UCSI University, Malaysia', '2011'],
        ],
        'alumni' => ['University of Manchester', 'UCSI University'],
        'qualifications' => [
            ['CISM', 'Certified Information Security Manager'],
            ['ITIL 4', 'ITIL 4 (IT service management)'],
            ['CC', 'ISC² Certified in Cybersecurity'],
            ['CSA', 'EC-Council Certified SOC Analyst'],
            ['CTIA', 'EC-Council Certified Threat Intelligence Analyst'],
        ],
        'expertise' => ['Security operations', 'Cyber threat intelligence', 'Security monitoring', 'Vulnerability management', 'Security technology integration', 'Technology consulting'],
    ],
    'hissein-banaye-hassan' => [
        'slug' => 'hissein-banaye-hassan',
        'name' => 'Hissein Banaye Hassan',
        'initials' => 'HB',
        'title' => 'Associate Consultant',
        'headline' => 'Cybersecurity Expert | Senior SOC Analyst | Cyber Threat Intelligence Specialist',
        'photo' => null,
        'featured' => false,
        'linkedin' => null,
        'summary' => 'Hissein Banaye Hassan is an experienced cybersecurity professional specialising in Security Operations, Cyber Threat Intelligence, incident response, threat hunting and information security management.',
        'belief' => null,
        'bio' => [
            'Hissein Banaye Hassan is an experienced cybersecurity professional specialising in Security Operations, Cyber Threat Intelligence, incident response, threat hunting and information security management. He brings practical expertise in detecting and mitigating sophisticated cyber threats, strengthening security operations and helping organisations build resilient digital environments.',
            'His technical expertise spans Security Information and Event Management (SIEM), Endpoint Detection and Response (EDR), Extended Detection and Response (XDR), network security, penetration testing, cybersecurity governance and risk management. He applies industry-recognised frameworks, including MITRE ATT&CK and NIST, to support effective threat detection, incident investigation and response.',
            'Beyond security operations, Hissein is passionate about cybersecurity education and professional development. He has delivered training in cybersecurity, network and systems administration, and web technologies, contributing to technical skills development and improved cybersecurity awareness.',
            'He holds a Master’s degree in Systems, Networks and Security from ESGIS and has professional certifications that include CEH, CompTIA CySA+, CompTIA Security+, ISO 27001, Microsoft SC-200, CISM, CISSP and Fortinet NSE certifications.',
            'At AMANIQ Projects Limited, Hissein contributes cybersecurity expertise, a commitment to continuous learning and a practical approach to security challenges. His focus is on helping organisations strengthen their security posture, improve operational resilience and navigate an increasingly complex digital landscape.',
        ],
        'education' => [
            ['Master’s degree in Systems, Networks and Security', 'ESGIS', null],
        ],
        'alumni' => ['ESGIS'],
        // Confirm exact credential names, levels and current status before launch.
        'qualifications' => [
            ['CEH', 'Certified Ethical Hacker'],
            ['CySA+', 'CompTIA Cybersecurity Analyst'],
            ['Security+', 'CompTIA Security+'],
            ['ISO 27001', 'ISO 27001 (information security management)'],
            ['SC-200', 'Microsoft Security Operations Analyst'],
            ['CISM', 'Certified Information Security Manager'],
            ['CISSP', 'Certified Information Systems Security Professional'],
            ['NSE', 'Fortinet NSE certifications'],
        ],
        'expertise' => ['Security operations', 'Cyber threat intelligence', 'Incident response', 'Threat hunting', 'SIEM, EDR and XDR', 'Governance and risk management'],
    ],
];
