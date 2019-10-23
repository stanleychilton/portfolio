import cx_Freeze

executables = [cx_Freeze.Executable("googleapitut.py")]

cx_Freeze.setup(
    name="comment",
    options={"build_exe":{"packages":["gspread", "oauth2client", "idna", "requests"], "include_files":["secret.json"]}},
    description="comment here",
    executables = executables
)