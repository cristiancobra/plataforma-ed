<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSocialmediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Campos obrigatórios básicos
            'socialmedia_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'URL_name' => 'required|url|max:500',
            'type' => 'required|string|max:100',
            'status' => 'required|string|max:100',

            // URLs opcionais
            'URL_studio' => 'nullable|url|max:500',

            // Contatos opcionais
            'socialmedia_phone' => 'nullable|string|max:20',
            'socialmedia_email' => 'nullable|email|max:255',

            // Campos de seleção (sim/não/parcialmente)
            'business' => 'nullable|in:sim,não,parcialmente',
            'linked_instagram' => 'nullable|in:sim,não,parcialmente',
            'linked_facebook' => 'nullable|in:sim,não,parcialmente',
            'same_site_name' => 'nullable|in:sim,não,parcialmente',
            'feed_content' => 'nullable|in:sim,não,parcialmente',
            'harmonic_feed' => 'nullable|in:sim,não,parcialmente',
            'SEO_descriptions' => 'nullable|in:sim,não,parcialmente',
            'feed_images' => 'nullable|in:sim,não,parcialmente',
            'stories' => 'nullable|in:sim,não,parcialmente',
            'interaction' => 'nullable|in:sim,não,parcialmente',
            'igtv' => 'nullable|in:sim,não,parcialmente',
            'reels' => 'nullable|in:sim,não,parcialmente',
            'employee_profiles' => 'nullable|in:sim,não,parcialmente',
            'employee_profiles_cv' => 'nullable|in:sim,não,parcialmente',
            'offers_job' => 'nullable|in:sim,não,parcialmente',
            'pin_content' => 'nullable|in:sim,não,parcialmente',
            'value_ads' => 'nullable|numeric|min:0|max:999999.99',
            'linktree' => 'nullable|in:sim,não,parcialmente',
            'image_banner' => 'nullable|in:sim,não,parcialmente',
            'organized_playlists' => 'nullable|in:sim,não,parcialmente',
            'liked_virtualstore' => 'nullable|in:sim,não,parcialmente',
            'video_banner' => 'nullable|in:sim,não,parcialmente',
            'legend' => 'nullable|in:sim,não,parcialmente',
            'feed_member' => 'nullable|in:sim,não,parcialmente',
            'follow_channel' => 'nullable|in:sim,não,parcialmente',

            // Campos de texto
            'about' => 'nullable|string|max:1000',
            'observation' => 'nullable|string|max:1000',

            // Números de seguidores
            'followers' => 'nullable|integer|min:0',

            // Keywords
            'keyword_1' => 'nullable|string|max:100',
            'keyword_2' => 'nullable|string|max:100',
            'keyword_3' => 'nullable|string|max:100',
            'keyword_4' => 'nullable|string|max:100',
            'keyword_5' => 'nullable|string|max:100',

            // Demografia masculina (porcentagens)
            'male_13_17' => 'nullable|integer|min:0|max:100',
            'male_18_24' => 'nullable|integer|min:0|max:100',
            'male_25_34' => 'nullable|integer|min:0|max:100',
            'male_35_44' => 'nullable|integer|min:0|max:100',
            'male_45_54' => 'nullable|integer|min:0|max:100',
            'male_55_65' => 'nullable|integer|min:0|max:100',
            'male_65' => 'nullable|integer|min:0|max:100',

            // Demografia feminina (porcentagens)
            'female_13_17' => 'nullable|integer|min:0|max:100',
            'female_18_24' => 'nullable|integer|min:0|max:100',
            'female_25_34' => 'nullable|integer|min:0|max:100',
            'female_35_44' => 'nullable|integer|min:0|max:100',
            'female_45_54' => 'nullable|integer|min:0|max:100',
            'female_55_65' => 'nullable|integer|min:0|max:100',
            'female_65' => 'nullable|integer|min:0|max:100',

            // Cidades dos seguidores
            'city_followers_1' => 'nullable|string|max:100',
            'number_city_followers_1' => 'nullable|integer|min:0',
            'city_followers_2' => 'nullable|string|max:100',
            'number_city_followers_2' => 'nullable|integer|min:0',
            'city_followers_3' => 'nullable|string|max:100',
            'number_city_followers_3' => 'nullable|integer|min:0',
        ];
    }


    /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => '*preenchimento obrigatório.',
            'string' => '*deve ser um texto.',
            'max' => '*máximo de :max caracteres.',
            'email' => '*formato de email inválido.',
            'url' => '*formato de URL inválido.',
            'integer' => '*deve ser um número inteiro.',
            'min' => '*valor mínimo é :min.',
            'in' => '*valor deve ser: sim, não ou parcialmente.',
            'value_ads.numeric' => '*deve ser um valor numérico.',
            'value_ads.min' => '*valor deve ser maior que zero.',
            'value_ads.max' => '*valor máximo permitido é R$ 999.999,99.',
            
        ];
    }
}
