namespace Drupal\tradedoubler_vouchers\Controller;

use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Client;

class VoucherController extends ControllerBase {
  public function voucherPage() {
    $client = new Client();
    $token = 'YOUR_API_TOKEN'; // Replace with your actual token
    $url = "https://api.tradedoubler.com/1.0/vouchers.json;pageSize=10?token=0684FD56DB0987C823E904CAD5B595DF11659A91";

    $response = $client->get($url);
    $data = json_decode($response->getBody(), true);

    $rows = [];
    foreach ($data['vouchers'] ?? [] as $voucher) {
      $rows[] = [
        $voucher['programName'] ?? '',
        $voucher['title'] ?? '',
        $voucher['description'] ?? '',
        $voucher['discount'] ?? '',
        $voucher['code'] ?? '',
        ['data' => ['#markup' => '<a href="' . $voucher['landingPage'] . '" target="_blank">Link</a>']],
        $voucher['endDate'] ?? '',
      ];
    }

    $header = ['Program Name', 'Title', 'Description', 'Discount', 'Code', 'Landing URL', 'Valid Until'];
    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#attributes' => ['class' => ['voucher-table']],
    ];
  }
}