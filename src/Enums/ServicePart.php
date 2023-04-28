<?php

namespace Astrogoat\GoLoadUp\Enums;

enum ServicePart: string
{
    case MATTRESS = 'Mattress';
    case ADJUSTABLE_BASE = 'Adjustable Base';
    case FOUNDATION = 'Foundation';

    public function code(ServiceType $serviceType): string
    {
        return match([$serviceType, $this])
        {
            [ServiceType::REMOVAL, ServicePart::MATTRESS] => 1,
            [ServiceType::REMOVAL, ServicePart::ADJUSTABLE_BASE] => 2,
            [ServiceType::REMOVAL, ServicePart::FOUNDATION] => 3,

            [ServiceType::SETUP, ServicePart::MATTRESS] => 4,
            [ServiceType::SETUP, ServicePart::ADJUSTABLE_BASE] => 5,
            [ServiceType::SETUP, ServicePart::FOUNDATION] => 6,
        };
    }
}
