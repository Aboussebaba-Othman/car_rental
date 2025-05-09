<?php

namespace App\Services;

class MoroccanCitiesService
{
    
    public function getAllCities(): array
    {
        return $this->getMoroccanCities();
    }

    private function getMoroccanCities(): array
    {
        return [
            'Agadir', 'Ahfir', 'Ain Harrouda', 'Ain Leuh', 'Al Hoceima', 'Asilah', 'Azemmour', 
            'Azrou', 'Beni Mellal', 'Benguerir', 'Berkane', 'Berrechid', 'Boujdour', 'Boulemane',
            'Casablanca', 'Chefchaouen', 'Dakhla', 'El Hajeb', 'El Jadida', 'Errachidia', 
            'Essaouira', 'Fès', 'Figuig', 'Fnideq', 'Fquih Ben Salah', 'Guelmim', 'Guercif', 
            'Ifrane', 'Imzouren', 'Inezgane', 'Jerada', 'Kénitra', 'Khemisset', 'Khenifra', 
            'Khouribga', 'Ksar El Kebir', 'Laâyoune', 'Larache', 'Marrakech', 'Martil', 
            'Meknès', 'Midelt', 'Mohammedia', 'Nador', 'Ouarzazate', 'Ouazzane', 'Oued Zem', 
            'Oujda', 'Rabat', 'Safi', 'Salé', 'Sefrou', 'Settat', 'Sidi Bennour', 'Sidi Ifni', 
            'Sidi Kacem', 'Sidi Slimane', 'Skhirate', 'Tangier', 'Tan-Tan', 'Taounate', 
            'Taroudant', 'Taza', 'Témara', 'Tétouan', 'Tinghir', 'Tiznit', 'Youssoufia', 'Zagora'
        ];
    }
}
