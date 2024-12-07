<?php

namespace App\Filament\Pages;

use App\Models\ShopProfile;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditShopProfile extends Page implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.edit-shop-profile';
    public function mount(): void
    {
        // Ambil data dari ShopProfile pertama
        $shopProfile = ShopProfile::first();

        if ($shopProfile) {
            // Isi form dengan data ShopProfile
            $this->form->fill($shopProfile->toArray());
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                Textarea::make('address')
                    ->required(),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('Save Shop Profile'))
                ->action(function () {
                    // Ambil data dari form
                    $data = $this->form->getState();

                    // Ambil entri pertama dari tabel ShopProfile (atau tambahkan logika lain jika perlu)
                    $shopProfile = ShopProfile::first();

                    if ($shopProfile) {
                        $shopProfile->update($data); // Perbarui data jika sudah ada
                    } else {
                        ShopProfile::create($data); // Buat data baru jika tidak ditemukan
                    }

                    // Kirim notifikasi ke pengguna
                    Notification::make()
                        ->title('Shop Profile Updated')
                        ->success()
                        ->send();
                })
                ->color('primary')
                // ->icon('heroicon-s-save')
                ->submit('save'),
        ];
    }
    public function save(): void
    {
        try {
            // Ambil data dari form
            $data = $this->form->getState();

            // Ambil data ShopProfile pertama (karena hanya ada satu data)
            $shopProfile = ShopProfile::first();

            if ($shopProfile) {
                // Perbarui data jika sudah ada
                $shopProfile->update($data);
            } else {
                // Buat entri baru jika belum ada
                ShopProfile::create($data);
            }

            // Kirim notifikasi keberhasilan
            Notification::make()
                ->title('Shop Profile Saved')
                ->success()
                ->send();
        } catch (\Exception $exception) {
            // Tangani error jika terjadi
            Notification::make()
                ->title('Failed to save Shop Profile')
                ->danger()
                ->send();
        }
    }
}
