<?php
/*
 * Service areas. Each entry produces a card on the home and services pages
 * and its own page at /services/{slug}/.
 *
 *   summary    one or two sentences used on cards and as the meta description
 *   intro      paragraphs at the top of the service page
 *   offerings  [title, description] pairs
 *   division   slug of the division that leads this work (see divisions.php), or null
 *   enquiry    contact-form enquiry type to preselect (see enquiry_types() in src/contact.php)
 *
 * Keep descriptions precise: do not add accreditations, partnerships or outcomes
 * that have not been verified.
 */
return [
    'cybersecurity' => [
        'slug' => 'cybersecurity',
        'title' => 'Cybersecurity and Information Security',
        'short' => 'Cybersecurity',
        'icon' => 'shield',
        'summary' => 'Advisory and implementation support that helps organisations understand their exposure, strengthen security operations and manage cyber risk with confidence.',
        'intro' => [
            'Cyber risk is a business risk. Organisations need to know where they stand, what matters most and which improvements will make a practical difference.',
            'We work alongside your team to assess, plan and strengthen your security capabilities, from security operations and threat intelligence to governance, risk and the integration of security technologies.',
        ],
        'offerings' => [
            ['Security operations and monitoring advisory', 'Guidance on establishing, maturing or reviewing security operations, including monitoring coverage, alert handling and operating procedures.'],
            ['Cyber threat intelligence', 'Support in building threat intelligence processes that turn relevant threat information into prioritised, practical action.'],
            ['Security assessment and improvement advisory', 'Structured reviews of security controls and practices, with clear, prioritised recommendations for improvement.'],
            ['Incident response and threat-hunting advisory', 'Help preparing for and responding to security incidents, and planning proactive threat-hunting activity.'],
            ['Security architecture and technology integration', 'Advice on security architecture and support integrating security technologies into existing environments.'],
            ['Cybersecurity governance, risk and compliance support', 'Support developing policies, risk assessments and governance practices aligned to recognised frameworks.'],
        ],
        'audiences' => ['Banks, financial institutions and fintech companies', 'Government agencies and public-sector organisations', 'Private companies and corporate organisations', 'Development and international organisations'],
        'division' => 'technologies',
        'enquiry' => 'cyber-it',
    ],
    'it-technology' => [
        'slug' => 'it-technology',
        'title' => 'IT Solutions and Technology Services',
        'short' => 'IT Solutions',
        'icon' => 'server',
        'summary' => 'Practical technology advice and implementation support, from planning and solution selection to integration and ongoing systems support.',
        'intro' => [
            'Good technology decisions start with a clear understanding of what the organisation needs to achieve. We help you plan, select and implement technology that fits your objectives, environment and budget.',
            'Our focus is on solutions that are secure, supportable and proportionate, not on technology for its own sake.',
        ],
        'offerings' => [
            ['IT consulting and implementation support', 'Hands-on support to plan and deliver technology projects, working with your team and suppliers.'],
            ['Technology planning and advisory', 'Help shaping technology roadmaps and priorities that align with business objectives.'],
            ['Security technology integration', 'Support integrating security tools and platforms so they work together and deliver useful information.'],
            ['IT systems and infrastructure support', 'Assistance with the systems and infrastructure your organisation depends on day to day.'],
            ['Technology evaluation and solution selection', 'Independent, structured evaluation of options to help you choose solutions with confidence.'],
        ],
        'audiences' => ['Private companies and corporate organisations', 'Public-sector organisations', 'Growing businesses formalising their technology'],
        'division' => 'technologies',
        'enquiry' => 'cyber-it',
    ],
    'consulting' => [
        'slug' => 'consulting',
        'title' => 'Business and Management Consulting',
        'short' => 'Consulting',
        'icon' => 'compass',
        'summary' => 'Advisory support that helps organisations improve processes, shape technology strategy and deliver projects and programmes with clarity.',
        'intro' => [
            'Many organisational challenges sit where business, process and technology meet. We help leaders understand the problem clearly, weigh the options and move forward with a practical plan.',
            'Each engagement is scoped with you, with agreed objectives, deliverables and timelines.',
        ],
        'offerings' => [
            ['Business process improvement', 'Mapping and improving how work gets done, so processes are clearer, more efficient and easier to manage.'],
            ['Technology strategy', 'Helping leadership align technology investment and priorities with organisational goals.'],
            ['Operational improvement', 'Identifying practical changes that improve reliability, efficiency and control.'],
            ['Project and programme support', 'Structured support for planning, governance and delivery of projects and programmes.'],
            ['Business analysis and advisory', 'Requirements gathering, options analysis and independent advice to support sound decisions.'],
        ],
        'audiences' => ['Executive and management teams', 'Public-sector organisations', 'Organisations planning change or new initiatives'],
        'division' => 'consulting',
        'enquiry' => 'consulting',
    ],
    'digital-products' => [
        'slug' => 'digital-products',
        'title' => 'Digital Products and Innovation',
        'short' => 'Digital Products',
        'icon' => 'layers',
        'summary' => 'Design and development of digital products, business software and web applications that make processes simpler and services easier to use.',
        'intro' => [
            'Well-built digital tools remove friction for staff and customers alike. We design and develop software that solves specific business problems, built with security and maintainability in mind from the start.',
            'We work iteratively, so you can see progress early, give feedback and shape the product as it develops.',
        ],
        'offerings' => [
            ['Digital product development', 'Turning an idea or requirement into a working digital product, from concept to release.'],
            ['Business software solutions', 'Software tailored to the way your organisation works, where off-the-shelf tools fall short.'],
            ['Web-based applications', 'Secure, responsive web applications for internal teams, partners or the public.'],
            ['Process digitisation', 'Replacing paper-based and manual processes with reliable digital workflows.'],
            ['Technology prototyping and innovation', 'Rapid prototypes that test an idea before larger investment is committed.'],
        ],
        'audiences' => ['Organisations digitising manual processes', 'Businesses developing new digital services', 'Teams needing tailored internal tools'],
        'division' => 'digital-labs',
        'enquiry' => 'digital',
    ],
    'training' => [
        'slug' => 'training',
        'title' => 'Professional Training and Development',
        'short' => 'Training',
        'icon' => 'book',
        'summary' => 'Cybersecurity awareness, technical training and professional development that build lasting skills in individuals and teams.',
        'intro' => [
            'Technology and security are only as strong as the people who use and manage them. We design and deliver training that is practical, relevant and matched to the audience, from all-staff awareness to specialist technical skills.',
            'Through AMANIQ Academy, we are also developing structured online learning for professionals and individuals.',
        ],
        'offerings' => [
            ['Cybersecurity awareness', 'Engaging awareness sessions that help staff recognise and respond to everyday security risks.'],
            ['Cybersecurity technical training', 'Hands-on technical training for security and IT practitioners.'],
            ['IT and technology skills development', 'Training that builds practical technology skills for teams and individuals.'],
            ['Professional development programmes', 'Structured programmes that support career growth and professional capability.'],
            ['Structured online learning through AMANIQ Academy', 'Self-paced and guided online courses delivered through AMANIQ Academy.'],
        ],
        'audiences' => ['Organisations training staff and technical teams', 'Professionals building cybersecurity and IT careers', 'Individuals interested in technology training'],
        'division' => 'academy',
        'enquiry' => 'training',
    ],
    'procurement' => [
        'slug' => 'procurement',
        'title' => 'Procurement and General Business Support',
        'short' => 'Procurement',
        'icon' => 'package',
        'summary' => 'Organised, transparent procurement support, from supplier sourcing and evaluation to technology and general goods and services procurement.',
        'intro' => [
            'Sound procurement protects budgets, timelines and reputations. We help organisations source, evaluate and coordinate the goods and services they need, with clear communication at each stage.',
            'Where an engagement requires specific registrations, approvals or documentation, we confirm those requirements with you at the outset.',
        ],
        'offerings' => [
            ['Procurement coordination', 'Coordinating requirements, suppliers and timelines so procurement runs smoothly.'],
            ['Supplier sourcing and evaluation', 'Identifying suitable suppliers and assessing options against your requirements.'],
            ['Technology procurement support', 'Technical input into specifying and sourcing hardware, software and services.'],
            ['General goods and services procurement', 'Sourcing a broad range of goods and services to agreed specifications.'],
            ['Tender and proposal support where appropriate', 'Support preparing clear, well-structured tender responses and proposals.'],
        ],
        'audiences' => ['Private companies and corporate organisations', 'Public-sector organisations', 'Development and international organisations'],
        'division' => null,
        'enquiry' => 'procurement',
    ],
];
