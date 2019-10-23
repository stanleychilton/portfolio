import cx_Freeze

executables = [cx_Freeze.Executable("comment.py")]

cx_Freeze.setup(
    name="Comments",
    options={"build_exe":{"packages":["gspread", "oauth2client", 'idna'], "include_files":['secret.json'] }},
    description = "comment on this",
    executables = executables
    )


