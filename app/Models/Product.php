<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $table = 'products';
    protected $fillable = [
        'id',
        'account_id',
        'image_id',
        'name',
        'cnae',
        'description',
        ' type',
        'category',
        'work_hours',
        'points',
        'hourly_cost',
        'cost1',
        'cost1_description',
        'cost2',
        'cost2_description',
        'cost3',
        'cost3_description',
        'tax_rate',
        'tax_amount',
        'margin_contribution',
        'margin_rate',
        'price',
        'initial_stock',
        'group',
        'status',
    ];
    protected $hidden = [
    ];

    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function contracts() {
        return $this->belongsToMany(Contract::class, 'contract_product');
    }

    public function image() {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    // MÉTODOS PÚBLICOS
// retorna categoria de produtos
    static function returnCategories() {
        return $categories = array(
            'serviço',
            'produto físico',
            'produto digital',
        );
    }

// retorna categoria de produtos
    static function returnGroups() {
        return $groups = array(
            'prolabore',
            'salário',
            'marketing',
            'produção',
            'contabilidade',
            'jurídico',
            'infraestrutura',
        );
    }

    public static function whatsappLink($product) {
        $account = Account::find($product->account_id);
        $phone = $account->whatsapp_sales;
        if ($phone == null) {
            return null;
        } else {
            $message = "Tenho%20interesse%20no%20produto%20$product->name%20";
            $phone = '55' . $phone;
            return "https://api.whatsapp.com/send?phone=$phone&text=$message";
        }
//            return https://api.whatsapp.com/send?phone=5516981076049&text=Preciso%20de%20ajuda%20com%20a%20minha%20empresa!%20;
    }

    public static function filterProducts($request) {
        $products = Product::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    if ($request->user_id) {
                        $query->where('user_id', $request->user_id);
                    }
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
                    if ($request->due_date) {
                        $query->where('due_date', '<', $request->date_due);
                    }
                    if ($request->category) {
                        $query->where('category', $request->type);
                    }
                    if ($request->type) {
                        $query->where('type', $request->type);
                    }
                    if ($request->status) {
                        $query->where('status', $request->status);
                    }
                    if ($request->variation) {
                        $query->where('type', $request->variation);
                    }
                    if ($request->trash == 1) {
                        $query->where('trash', 1);
                    } else {
                        $query->where('trash', '!=', 1);
                    }
                })
                ->orderBy('name', 'ASC')
                ->paginate(20);

        $products->appends([
            'name' => $request->name,
            'status' => $request->status,
            'category' => $request->category,
            'variation' => $request->variation,
        ]);

        return $products;
    }

}
