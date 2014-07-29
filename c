USAGE
	git-ftp <action> [<options>] <url>


DESCRIPTION
	git-ftp does FTP the Git way.

	It uses Git to determine which local files have changed since the last
	deployment to the remote server and saves you time and bandwidth by
	uploading only those files.

	It keeps track of the deployed state by uploading the SHA1 of the last
	deployed commit in a log file.


ACTIONS
	. init
		Does an initial upload of the latest version of all non-ignored
		git-tracked files to the remote server and creates .git-ftp.log
		file containing the SHA1 of the latest commit.

	. push
		Uploads git-tracked files which have changed since last upload.

	. show
		Downloads last uploaded SHA1 from log and hooks `git show`.

	. log
		Downloads last uploaded SHA1 from log and hooks `git log`.

	. catchup
		Uploads current SHA1 to log, does not upload any files.

		This is useful if you used another FTP client to upload the
		files and now want to remember the SHA1.

	. add-scope
		Add a scope (e.g. dev, production, testing).

	. remove-scope
		Completely remove a scope.

	. help
		Shows this help screen.


URL
	. FTP (default)		host.example.com[:<port>][/<remote path>]
	. FTP			ftp://host.example.com[:<port>][/<remote path>]
	. SFTP			sftp://host.example.com[:<port>][/<remote path>]
	. FTPS			ftps://host.example.com[:<port>][/<remote path>]
	. FTPES			ftpes://host.example.com[:<port>][/<remote path>]


OPTIONS
	-h, --help		Shows this help screen.
	-u, --user		FTP login name.
	-p, --passwd		FTP password.
	-k, --keychain		FTP password from KeyChain (Mac OS X only).
	-s, --scope		Using a scope (e.g. dev, production, testing).
	-D, --dry-run		Dry run: Does not upload anything.
	-a, --all		Uploads all files, ignores deployed SHA1 hash.
	-c, --commit		Sets SHA1 hash of last deployed commit by option.
	-A, --active		Use FTP active mode.
	-l, --lock		Enable/Disable remote locking.
	-f, --force		Force, does not ask questions.
	-n, --silent		Silent mode.
	-v, --verbose		Verbose mode.
	-vv			Very verbose or debug mode.
	--syncroot		Specifies a local directory to sync from as if it were the git project root path.
	--insecure		Don't verify server's certificate.
	--cacert		Specify a <file> as CA certificate store. Useful when a server has got a self-signed certificate.
	--disable-epsv		Tell curl to disable the use of the EPSV command when doing passive FTP transfers. Curl will normally always first attempt to use EPSV before PASV, but with this option, it will not try using EPSV.
	--version		Prints version.


EXAMPLES
	. git-ftp push -u john ftp://ftp.example.com:4445/public_ftp -p -v
	. git-ftp push -p -u john -v ftp.example.com:4445:/public_ftp
	. git-ftp add-scope production ftp://user:secr3t@ftp.example.com:4445/public_ftp
	. git-ftp push --scope production
	. git-ftp remove-scope production


SET DEFAULTS
	. git config git-ftp.user john
	. git config git-ftp.url ftp.example.com
	. git config git-ftp.password secr3t
	. git config git-ftp.syncroot path/dir
	. git config git-ftp.cacert path/cacert
	. git config git-ftp.deployedsha1file mySHA1File
	. git config git-ftp.insecure 1


SET SCOPE DEFAULTS 
	e.g. your scope is 'testing'
	. git config git-ftp.testing.url ftp.example.local


VERSION
	1.0.0-rc.2
