http_path = "web"
css_dir = "css"
sass_dir = "sass"
images_dir = "img"
javascripts_dir = "js"

relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
line_comments = false
environment = :production

if environment == :production
  output_style = :compressed
else
  output_style = :expanded
  sass_options = { :debug_info => true }
end
