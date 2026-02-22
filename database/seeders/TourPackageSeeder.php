<?php

namespace Database\Seeders;

use App\Models\TourPackage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TourPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Cameron Highlands Nature Escape',
                'slug' => 'cameron-highlands-nature-escape',
                'short_description' => 'Experience the cool mountain air, lush tea plantations, and strawberry farms of Cameron Highlands.',
                'description' => 'Escape the city heat and immerse yourself in the cool, refreshing atmosphere of Cameron Highlands. This 3-day tour takes you through rolling tea plantations, vibrant strawberry farms, and beautiful flower gardens. Enjoy local delicacies, visit the famous Boh Tea Plantation, and explore the mossy forest.',
                'price' => 450.00,
                'duration' => '3 Days 2 Nights',
                'destination' => 'Cameron Highlands, Pahang',
                'category' => 'nature',
                'inclusions' => ['Return transportation from KL', '2 nights accommodation', 'Breakfast (2x)', 'Guided tours', 'Entrance fees'],
                'exclusions' => ['Personal expenses', 'Travel insurance', 'Lunch and dinner', 'Optional activities'],
                'itinerary' => [
                    ['day' => 1, 'title' => 'Arrival & Tea Plantation', 'description' => 'Depart from KL, arrive at Cameron Highlands. Visit Boh Tea Plantation and enjoy high tea.'],
                    ['day' => 2, 'title' => 'Nature Exploration', 'description' => 'Morning visit to Mossy Forest, strawberry farm, and butterfly garden. Free time in the afternoon.'],
                    ['day' => 3, 'title' => 'Market & Departure', 'description' => 'Visit local market for souvenirs, depart for KL.'],
                ],
                'max_pax' => 12,
                'difficulty' => 'easy',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Langkawi Island Adventure',
                'slug' => 'langkawi-island-adventure',
                'short_description' => 'Discover the jewels of Kedah with island hopping, cable car rides, and beach relaxation.',
                'description' => 'Langkawi, the Jewel of Kedah, offers pristine beaches, lush rainforests, and exciting adventures. Take a cable car ride to Mount Mat Cincang, go island hopping, and relax on beautiful Pantai Cenang.',
                'price' => 699.00,
                'duration' => '4 Days 3 Nights',
                'destination' => 'Langkawi, Kedah',
                'category' => 'beach',
                'inclusions' => ['Return flights from KL', '3 nights beach resort', 'Daily breakfast', 'Island hopping tour', 'Cable car & Sky Bridge', 'Airport transfers'],
                'exclusions' => ['Personal expenses', 'Marine park fee', 'Lunch and dinner', 'Water sports activities'],
                'itinerary' => [
                    ['day' => 1, 'title' => 'Arrival & Beach Time', 'description' => 'Arrive at Langkawi, transfer to resort. Free time at Pantai Cenang.'],
                    ['day' => 2, 'title' => 'Island Hopping', 'description' => 'Full day island hopping tour visiting Dayang Bunting, Beras Basah, and Singa Besar.'],
                    ['day' => 3, 'title' => 'Sky Adventure', 'description' => 'Morning cable car ride and Sky Bridge. Afternoon free for shopping at Kuah.'],
                    ['day' => 4, 'title' => 'Departure', 'description' => 'Free morning, transfer to airport for departure.'],
                ],
                'max_pax' => 15,
                'difficulty' => 'easy',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Penang Heritage & Food Trail',
                'slug' => 'penang-heritage-food-trail',
                'short_description' => 'Explore Georgetown\'s UNESCO heritage sites and savor the best street food in Malaysia.',
                'description' => 'Penang is a melting pot of cultures, offering incredible heritage architecture, vibrant street art, and world-famous cuisine. This tour combines cultural exploration with a gastronomic journey through Georgetown.',
                'price' => 380.00,
                'duration' => '3 Days 2 Nights',
                'destination' => 'Georgetown, Penang',
                'category' => 'culinary',
                'inclusions' => ['Return transportation', '2 nights heritage hotel', 'Daily breakfast', 'Street food tour', 'Trishaw ride', 'Heritage guide'],
                'exclusions' => ['Personal expenses', 'Most meals', 'Museum entrance fees', 'Souvenirs'],
                'itinerary' => [
                    ['day' => 1, 'title' => 'Heritage Walk', 'description' => 'Arrive in Georgetown, heritage walk through Armenian Street, street art hunting.'],
                    ['day' => 2, 'title' => 'Food Trail', 'description' => 'Morning food tour sampling local delights. Afternoon at Kek Lok Si Temple. Evening hawker feast.'],
                    ['day' => 3, 'title' => 'Hill & Departure', 'description' => 'Morning Penang Hill funicular train. Afternoon departure.'],
                ],
                'max_pax' => 10,
                'difficulty' => 'easy',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Mount Kinabalu Summit Climb',
                'slug' => 'mount-kinabalu-summit-climb',
                'short_description' => 'Challenge yourself to conquer Southeast Asia\'s highest peak at 4,095 meters.',
                'description' => 'A once-in-a-lifetime adventure to summit Mount Kinabalu, the highest peak in Southeast Asia. This challenging trek rewards you with breathtaking sunrise views and a sense of accomplishment.',
                'price' => 1500.00,
                'duration' => '3 Days 2 Nights',
                'destination' => 'Kinabalu Park, Sabah',
                'category' => 'adventure',
                'inclusions' => ['Climbing permit', 'Mountain guide', 'Porter service', '1 night at Laban Rata', 'Meals during climb', 'Certificate'],
                'exclusions' => ['Flights to KK', 'Personal gear', 'Travel insurance', 'Additional nights'],
                'itinerary' => [
                    ['day' => 1, 'title' => 'Registration & Start', 'description' => 'Register at park HQ, begin climb to Laban Rata resthouse (3,272m).'],
                    ['day' => 2, 'title' => 'Summit Day', 'description' => '2 AM start for summit attempt. Reach Low\'s Peak for sunrise. Descend to HQ.'],
                    ['day' => 3, 'title' => 'Recovery', 'description' => 'Rest day, optional visit to Poring Hot Springs.'],
                ],
                'max_pax' => 8,
                'difficulty' => 'challenging',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Malacca Historical Day Trip',
                'slug' => 'malacca-historical-day-trip',
                'short_description' => 'Step back in time and explore the rich history of this UNESCO World Heritage city.',
                'description' => 'Discover 600 years of history in Malacca, from the Malacca Sultanate to Portuguese, Dutch, and British colonial periods. Visit iconic landmarks, sample Nyonya cuisine, and cruise the historic river.',
                'price' => 150.00,
                'duration' => 'Full Day Trip',
                'destination' => 'Malacca',
                'category' => 'cultural',
                'inclusions' => ['Return transportation', 'English-speaking guide', 'River cruise', 'Lunch', 'Entrance fees'],
                'exclusions' => ['Personal expenses', 'Optional activities', 'Souvenirs'],
                'itinerary' => [
                    ['day' => 1, 'title' => 'Historical Tour', 'description' => 'Visit Stadthuys, Christ Church, A Famosa, St. Paul\'s Hill, and Baba Nyonya Heritage Museum. River cruise and local lunch included.'],
                ],
                'max_pax' => 20,
                'difficulty' => 'easy',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Taman Negara Rainforest Expedition',
                'slug' => 'taman-negara-rainforest-expedition',
                'short_description' => 'Explore one of the world\'s oldest rainforests, estimated at 130 million years old.',
                'description' => 'Journey into Taman Negara, one of the oldest rainforests in the world. Experience canopy walks, jungle trekking, rapid shooting, and wildlife observation in this pristine wilderness.',
                'price' => 550.00,
                'duration' => '3 Days 2 Nights',
                'destination' => 'Taman Negara, Pahang',
                'category' => 'adventure',
                'inclusions' => ['Return boat transfers', '2 nights resort', 'All meals', 'Canopy walk', 'Jungle trek guide', 'Rapid shooting'],
                'exclusions' => ['Camera fee', 'Personal expenses', 'Travel insurance', 'Optional night walk'],
                'itinerary' => [
                    ['day' => 1, 'title' => 'River Journey', 'description' => 'Boat ride up Tembeling River, check-in, evening night walk.'],
                    ['day' => 2, 'title' => 'Rainforest Adventure', 'description' => 'Canopy walk, jungle trek to Bukit Teresek, rapid shooting, cave exploration.'],
                    ['day' => 3, 'title' => 'Orang Asli Village', 'description' => 'Visit indigenous village, blowpipe demonstration, return journey.'],
                ],
                'max_pax' => 10,
                'difficulty' => 'moderate',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'KL City Highlights Tour',
                'slug' => 'kl-city-highlights-tour',
                'short_description' => 'Discover the best of Kuala Lumpur including PETRONAS Twin Towers, Batu Caves, and more.',
                'description' => 'Experience the best of Malaysia\'s vibrant capital. Visit iconic landmarks including the PETRONAS Twin Towers, Batu Caves, National Mosque, and explore local markets and food spots.',
                'price' => 180.00,
                'duration' => 'Full Day Tour',
                'destination' => 'Kuala Lumpur',
                'category' => 'city',
                'inclusions' => ['Hotel pickup/drop-off', 'Air-conditioned transport', 'English guide', 'Lunch', 'Entrance fees'],
                'exclusions' => ['Personal expenses', 'PETRONAS Sky Bridge ticket', 'Souvenirs', 'Tips'],
                'itinerary' => [
                    ['day' => 1, 'title' => 'City Explorer', 'description' => 'Morning: Batu Caves & Royal Selangor. Afternoon: National Mosque, Merdeka Square, PETRONAS Twin Towers photo stop. Evening: Local food dinner.'],
                ],
                'max_pax' => 15,
                'difficulty' => 'easy',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Perhentian Islands Snorkeling',
                'slug' => 'perhentian-islands-snorkeling',
                'short_description' => 'Crystal clear waters, vibrant coral reefs, and pristine beaches await at Perhentian Islands.',
                'description' => 'Escape to paradise at the Perhentian Islands. Snorkel in crystal-clear waters, relax on white sandy beaches, and experience the laid-back island vibe of this marine paradise.',
                'price' => 480.00,
                'duration' => '3 Days 2 Nights',
                'destination' => 'Perhentian Islands, Terengganu',
                'category' => 'beach',
                'inclusions' => ['Return boat transfers', '2 nights beach chalet', 'Daily breakfast', 'Snorkeling trips', 'Snorkeling gear', 'Marine park fee'],
                'exclusions' => ['Transport to jetty', 'Lunch and dinner', 'Diving activities', 'Kayak rental'],
                'itinerary' => [
                    ['day' => 1, 'title' => 'Island Arrival', 'description' => 'Boat transfer to island, check-in, free time for swimming and snorkeling.'],
                    ['day' => 2, 'title' => 'Snorkeling Day', 'description' => 'Full day snorkeling tour visiting Turtle Bay, Shark Point, and coral gardens.'],
                    ['day' => 3, 'title' => 'Beach Day & Departure', 'description' => 'Morning relaxation, optional activities, afternoon departure.'],
                ],
                'max_pax' => 12,
                'difficulty' => 'easy',
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($packages as $package) {
            TourPackage::create($package);
        }

        $this->command->info('Created ' . count($packages) . ' tour packages.');
    }
}
