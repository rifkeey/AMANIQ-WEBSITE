<?php
declare(strict_types=1);

/*
 * Structured data (JSON-LD). Only facts supplied by the company are used:
 * no ratings, reviews, founding dates or service areas are claimed.
 */

function json_ld(array $data): string
{
    return '<script type="application/ld+json">'
        . json_encode(['@context' => 'https://schema.org'] + $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP)
        . '</script>';
}

function organization_schema(): array
{
    $org = [
        '@type' => 'Organization',
        '@id' => absolute_url('/') . '#organization',
        'name' => company('brand'),
        'legalName' => company('legal_name'),
        'url' => absolute_url('/'),
        'logo' => site_origin() . base_path() . '/assets/img/brand/amaniq-logo-512.png',
        'email' => company('email'),
        'telephone' => company('phone'),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => company('address.street'),
            'addressLocality' => company('address.locality'),
            'addressRegion' => company('address.region'),
            'addressCountry' => company('address.country_code'),
        ],
        'identifier' => [
            '@type' => 'PropertyValue',
            'propertyID' => 'Corporate Affairs Commission (CAC) registration number',
            'value' => company('rc'),
        ],
        'department' => array_values(array_map(static fn (array $d) => [
            '@type' => 'Organization',
            'name' => $d['name'],
            'url' => absolute_url('/divisions/' . $d['slug'] . '/'),
        ], content('divisions'))),
    ];
    $sameAs = array_values(array_filter([company('linkedin')]));
    if ($sameAs) {
        $org['sameAs'] = $sameAs;
    }
    return $org;
}

function website_schema(): array
{
    return [
        '@type' => 'WebSite',
        '@id' => absolute_url('/') . '#website',
        'url' => absolute_url('/'),
        'name' => company('brand'),
        'publisher' => ['@id' => absolute_url('/') . '#organization'],
        'inLanguage' => 'en-GB',
    ];
}

/** @param list<array{0:string,1:string}> $crumbs */
function breadcrumb_schema(array $crumbs): array
{
    $items = [];
    foreach (array_merge([['Home', '/']], $crumbs) as $i => [$label, $path]) {
        $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $label, 'item' => absolute_url($path)];
    }
    return ['@type' => 'BreadcrumbList', 'itemListElement' => $items];
}

function service_schema(array $service): array
{
    return [
        '@type' => 'Service',
        'name' => $service['title'],
        'serviceType' => $service['title'],
        'description' => $service['summary'],
        'url' => absolute_url('/services/' . $service['slug'] . '/'),
        'provider' => ['@id' => absolute_url('/') . '#organization'],
        'hasOfferCatalog' => [
            '@type' => 'OfferCatalog',
            'name' => $service['title'],
            'itemListElement' => array_map(static fn (array $item) => [
                '@type' => 'Offer',
                'itemOffered' => ['@type' => 'Service', 'name' => $item[0]],
            ], $service['offerings']),
        ],
    ];
}

function person_schema(array $member): array
{
    $person = [
        '@type' => 'Person',
        'name' => $member['name'],
        'jobTitle' => $member['title'],
        'worksFor' => ['@id' => absolute_url('/') . '#organization'],
        'url' => absolute_url('/team/') . '#' . $member['slug'],
    ];
    if (!empty($member['alumni'])) {
        $person['alumniOf'] = array_map(static fn (string $name) => ['@type' => 'CollegeOrUniversity', 'name' => $name], $member['alumni']);
    }
    return $person;
}
