{{--
@if(Config::get('app.locale') == 'ru')
    <script type='application/ld+json'> {
        "@context": "http://www.schema.org",
        "@type": "BusinessEvent",
        "name": "MONACO INTERNATIONAL LUXURY PROPERTY EXPO",
        "url": "https://ilpexpo.com/ru",
        "description": "Крупнейшая в мире международная выставка элитной зарубежной недвижимости в формате B2C",
        "image": "{{url(asset('images/ilpe.jpg'))}}",
        "startDate": "2019-05-15T10:00",
        "endDate": "2019-05-16T23:00",
        "performer": "International Luxury Property Expo",
        "location": {
            "@type": "Place",
            "name": "Grimaldi Forum",
            "sameAs": "https://www.grimaldiforum.com",
            "address": {
            "@type": "PostalAddress",
            "streetAddress": "10 Av. Princesse Grace",
            "addressLocality": "Monaco",
            "postalCode": "98000",
            "addressCountry": "Monaco"
            }
        },
        "offers": {
            "@type": "Offer",
            "description": "Ticket",
            "url": "https://ilpexpo.ticketforevent.com/ru/monaco2019/",
            "availability": "http://schema.org/InStock",
            "price": "1000.00",
            "priceCurrency": "EUR",
            "validFrom": "2019-03-01T10:00"
        }
    }
    </script>
@else
    <script type='application/ld+json'> {
    "@context": "http://www.schema.org",
    "@type": "BusinessEvent",
    "name": "MONACO INTERNATIONAL LUXURY PROPERTY EXPO",
    "url": "https://ilpexpo.com/",
    "description": "The world's central B2C exhibition for luxury international real estate",
    "image": "{{url(asset('images/ilpe.jpg'))}}",
    "startDate": "2019-05-15T10:00",
    "endDate": "2019-05-16T23:00",
    "performer": "International Luxury Property Expo",
    "location": {
        "@type": "Place",
        "name": "Grimaldi Forum",
        "sameAs": "https://www.grimaldiforum.com",
        "address": {
        "@type": "PostalAddress",
        "streetAddress": "10 Av. Princesse Grace",
        "addressLocality": "Monaco",
        "postalCode": "98000",
        "addressCountry": "Monaco"
        }
    },
    "offers": {
        "@type": "Offer",
        "description": "Ticket",
        "url": "https://ilpexpo.ticketforevent.com/en/monaco2019/",
        "availability": "http://schema.org/InStock",
        "price": "1000.00",
        "priceCurrency": "EUR",
        "validFrom": "2019-03-01T10:00"
    }
}
</script>
@endif--}}
