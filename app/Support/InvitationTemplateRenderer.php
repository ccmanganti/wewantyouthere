<?php
namespace App\Support;
use App\Models\InvitationWebsite;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
class InvitationTemplateRenderer {
 public function render(InvitationWebsite $website): string {
  $template=$website->template;
  if (!$template || !$template->code_path || !Storage::disk('local')->exists($template->code_path)) {
   throw new RuntimeException('Template source is unavailable.');
  }
  $source=Storage::disk('local')->get($template->code_path);
  $allowed=$template->eventType->questions()->where('is_enabled',true)->pluck('key')->all();
  $answers=array_intersect_key($website->answers ?? [],array_flip($allowed));
  return preg_replace_callback('/\{\{\s*([a-z][a-z0-9_]*)\s*\}\}/i',function(array $match) use($answers) {
   $value=$answers[$match[1]] ?? '';
   if (is_array($value)) $value=implode(', ',array_map('strval',$value));
   return e((string)$value);
  },$source);
 }
}
