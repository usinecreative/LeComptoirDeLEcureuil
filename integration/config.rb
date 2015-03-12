# Require any additional compass plugins here.

# Set this to the root of your project when deployed:
common_dir = "/"

http_path = "integration"
sass_dir = common_dir + "scss"
images_dir = common_dir + "images"

css_dir = common_dir + "css"
generated_images_dir = common_dir + "images"
javascripts_dir = common_dir + "js"

relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
line_comments = false
environment = :dev

if environment == :production
  output_style = :compressed
else
  output_style = :expanded
  sass_options = { :debug_info => true }
end